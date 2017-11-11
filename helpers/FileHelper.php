<?php
namespace app\helpers;

use Yii;
use common\models\fileuploads\FileUploads;

class FileHelper extends \yii\helpers\FileHelper
{
    public static function getData($url, $isImage = false)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,$timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if($isImage)
        {
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        }
        else
        {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }

        $data = curl_exec($ch);
        if(curl_exec($ch) === false)
            return null;

        if(curl_getinfo($ch, CURLINFO_HTTP_CODE)!=200) return null;

        curl_close($ch);

        return $data;
    }

    public static function is_image($filename) {
        $is = @getimagesize($filename);
        if ( !$is ) return false;
        elseif ( !in_array($is[2], [1,2,3]) ) return false;
        else return true;
    }

    public static function getFileFromBase64($file_name, $file_ext, $data, $settings_str)
    {
        if(strlen(trim($file_name))>0 && strlen(trim($file_ext))>0 && strlen(trim($data))>0 && strlen(trim($settings_str))>0) {
            $uploadSettings = FileUploads::uploadSettings($settings_str);
            $tmp_file = new FileUploads();
            $tmp_file->file_extention = $file_ext;
            $tmp_file->file_realname = $file_name;
            $tmp_file->file_path = '/' . $uploadSettings['uploadPath'];
            if ($tmp_file->saveTmpFile()) {
                $file_name = Yii::getAlias('@root') . '/' . $tmp_file->getFileUrl();
                if ($f = fopen($file_name, 'w')) {
                    fwrite($f, base64_decode($data));
                    fclose($f);

                    return $tmp_file;
                }
            }
        }

        return null;
    }
}