<?php
namespace app\helpers;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

class ViewHelper {
	public static function convertToSqlDate($date)
	{
		if (false !== ($time = strtotime($date))) {
			return date('Y-m-d', $time);
		}

		return null;
	}

	public static function convertToViewDate($date, $format='m/d/Y')
	{
		if (false !== ($time = strtotime($date))) {
			return date($format, $time);
		}

		return null;
	}

	public static function convertToViewTime($date, $format='g:i A')
	{
		if (false !== ($time = strtotime($date))) {
			return date($format, $time);
		}

		return null;
	}

	public static function convertToSqlTime($date)
	{
		if (false !== ($time = strtotime($date))) {
			return date('H:i:s', $time);
		}

		return null;
	}

	public static function getMonthArray()
	{
		return [
			1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May',	6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'Octovber', 11=>'November', 12=>'December',
		];
	}

	public static function getMonthName($id)
	{
		$month_arr = static::getMonthArray();

		$id = (int)$id;
		return (isset($month_arr[$id])) ? $month_arr[$id] : '';
	}

	public static function imageCropForm($id='image', $imageModel, $width=300, $height=300, $crop_coords=[], $use_crop=true)
	{
		$result = '';
		$crop_params = [];
		$crop_coords_str = '';
		$image_width = '';
		$preview_image_src = '';

		if($imageModel)
		{
			$preview_image_src = ImageHelper::getPicture($imageModel->getFileUrl(['crop_image'=>false]), $width, $height);
			if($use_crop && $preview_image_info = @getimagesize(Yii::getAlias('@root').$preview_image_src))
			{
				if(count($crop_coords)<=0)
				{
					$crop_coords = $imageModel->getImageCrop($preview_image_info[0]);
				}
				else
				{
					if(isset($crop_coords['0'])) $crop_coords['x'] = $crop_coords['0'];
					if(isset($crop_coords['1'])) $crop_coords['y'] = $crop_coords['1'];
					if(isset($crop_coords['2'])) $crop_coords['x1'] = $crop_coords['2'];
					if(isset($crop_coords['3'])) $crop_coords['y1'] = $crop_coords['3'];
				}

				$image_width = $preview_image_info[0];

				if(count($crop_coords)>0) $crop_params['setSelect'] = [$crop_coords['x'], $crop_coords['y'], $crop_coords['x1'], $crop_coords['y1']];

				$image_crop_ratio = $imageModel->getImageCropRatio($image_width);
				$min_size = ($image_crop_ratio['width']>0 && $image_crop_ratio['height']>0) ? [$image_crop_ratio['width'], $image_crop_ratio['height']] : [];
				$crop_params['minSize'] = $min_size;
				$crop_params['aspectRatio'] = $image_crop_ratio['ratio'];


				$result .= '<script>
					$("#'.$id.'").ready(function(){
						var params = $("#'.$id.'-frame").data("crop-params");
					    initCropImage("'.$id.'", params);
					});
				</script>';
			}
		}
		$result .= Html::hiddenInput($id.'-image-width', $image_width, ['id'=>$id.'-image-width']);
		$result .= Html::hiddenInput($id.'-coords', $crop_coords_str, ['id'=>$id.'-coords']);

		$result .= '<div id="'.$id.'-frame" data-crop-params="'.Html::encode(json_encode($crop_params)).'" class="text-center mb15">';
		if(strlen($preview_image_src)>0) $result .= Html::img($preview_image_src, ['id'=>$id]);
		$result .= '</div>';

		return $result;
	}

	public static function getYearsOld($date)
	{
		$years = date('Y') - date('Y', strtotime($date));
		if(date('m-d')<date('m-d', strtotime($date))) $years--;

		return $years;
	}

	/**
	 * Configuration option tags for country dropdown like this: <option value="1" alpha2="USA">United states</option>
	 * @param $countries_arr - [['country_id'=>'country_name'], ....]
	 * @param $code_type - [iso, alpha2, alpha3]
	 */
	public static function getCountryOptionsWithCode($countries_arr, $code_type)
	{
		$options_arr = [];
		foreach($countries_arr as $k=>$v)
		{
			$options_arr[$k] = [$code_type=>$v];
		}

		return $options_arr;
	}

	/**
	 * @param string $date in format (yyyy-mm-dd hh::ii:ss)
	 */
	public static function getEventDate($date)
	{
		if(date('Y-m-d', strtotime($date))==date('Y-m-d')) return 'today';
		if(date('Y-m-d', strtotime($date)+(60*60*24))==date('Y-m-d')) return 'yesterday';
		if(date('Y', strtotime($date))==date('Y')) return (date('d', strtotime($date))*1).' '.self::getMonthName(date('m', strtotime($date))*1, true);

		return (date('d', strtotime($date))*1).' '.self::getMonthName(date('m', strtotime($date))*1, true).' '.date('Y', strtotime($date));
	}

	/**
	 *
	 * Do line breaks in text created in textarea
	 * @param string $text
	 */
	public static function lineBreaks($text)
	{
		$text = preg_replace("/\\n{2,}/", "<br /><br />", $text);
		$text = preg_replace("/\\n+/", "<br />", $text);
		return $text;
	}

	public static function plainLinks2Html($text, $linkAttributes=array())
	{
		$defaultAttributes = ['target'=>'_blank', 'rel'=>'nofollow'];
		$ignoreAttributes = ['href'];
		$attributes_atr = '';

		foreach ($defaultAttributes as $k=>$v)
		{
			if(!in_array($k, $ignoreAttributes) && !in_array($k, $linkAttributes))
			{
				if(strlen($attributes_atr)>0) $attributes_atr .= ' ';
				$attributes_atr .= $k.'="'.Html::encode($v).'"';
			}
		}

		foreach ($linkAttributes as $k=>$v)
		{
			if(!in_array($k, $ignoreAttributes))
			{
				if(strlen($attributes_atr)>0) $attributes_atr .= ' ';
				$attributes_atr .= $k.'="'.Html::encode($v).'"';
			}
		}

		$link_pattern = '#(https?://)?([\w-@]+\.)+(MUSEUM|TRAVEL|AERO|ARPA|ASIA|EDU|GOV|MIL|MOBI|COOP|INFO|NAME|BIZ|CAT|COM|INT|JOBS|NET|ORG|PRO|TEL|A[CDEFGILMNOQRSTUWXZ]|B[ABDEFGHIJLMNORSTVWYZ]|C[ACDFGHIKLMNORUVXYZ]|D[EJKMOZ]|E[CEGHRSTU]|F[IJKMOR]|G[ABDEFGHILMNPQRSTUWY]|H[KMNRTU]|I[DELMNOQRST]|J[EMOP]|K[EGHIMNPRWYZ]|L[ABCIKRSTUVY]|M[ACDEFGHKLMNOPQRSTUVWXYZ]|N[ACEFGILOPRUZ]|OM|P[AEFGHKLMNRSTWY]|QA|R[EOSUW]|S[ABCDEGHIJKLMNORTUVYZ]|T[CDFGHJKLMNOPRTVWZ]|U[AGKMSYZ]|V[ACEGINU]|W[FS]|Y[ETU]|Z[AMW])(\S*)?#i';
		if (preg_match_all($link_pattern, $text, $matches))
		{
			$matches = array_unique($matches[0]);
			foreach ($matches as $match)
			{
				$match = trim($match, ' ,.?!;:(){}[]');
				$link_url = $match;
				if (false !== strpos($match, '@')) {
					$link = '<a href="mailto:'.$link_url.'">'.$match.'</a>';
				} else {
					if(strpos($match, 'http://')===false && strpos($match, 'https://')===false) $link_url = 'http://'.$match;
					$link = '<a '.$attributes_atr.' href="'.$link_url.'">'.$match.'</a>';
				}
				$text = preg_replace(
					'~'.preg_quote($match).'((?!">))(?!<)~', // replace if match is not followed by "> or <
					$link, // important that href is the last attribute
					$text);
			}
		}
		return $text;
	}
}