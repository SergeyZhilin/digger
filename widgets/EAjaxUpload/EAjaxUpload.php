<?php
namespace demonId\ajaxFileUploader;

use Yii;
use yii\base\Exception;

/**
 * EAjaxUpload class file.
 * This extension is a wrapper of http://valums.com/ajax-upload/
 *
 * @author Vladimir Papaev <kosenka@gmail.com>
 * @version 0.1
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
        How to use:

        view:
		 $this->widget('ext.EAjaxUpload.EAjaxUpload',
                 array(
                       'id'=>'uploadFile',
                       'config'=>array(
                                       'action'=>'/controller/upload',
                                       'allowedExtensions'=>array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...
                                       'sizeLimit'=>10*1024*1024,// maximum file size in bytes
                                       'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
                                       //'onComplete'=>"js:function(id, fileName, responseJSON){ alert(fileName); }",
                                       //'messages'=>array(
                                       //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                       //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                       //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                       //                  'emptyError'=>"{file} is empty, please select files again without it.",
                                       //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                       //                 ),
                                       //'showMessage'=>"js:function(message){ alert(message); }"
                                      )
                      ));

        controller:

	public function actionUpload()
	{
	        Yii::import("ext.EAjaxUpload.qqFileUploader");
	        
                $folder='upload/';// folder for uploaded files
                $allowedExtensions = array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...
                $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
                $result = $uploader->handleUpload($folder);
                $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
                echo $result;// it's array
	}

*/
class EAjaxUpload extends \yii\base\Widget
{
    public $id = "fileUploader";
	public $postParams = [];
	public $config = [];
	public $css = null;
    public $initOnly = false;

    public function init()
    {
        if(!$this->initOnly)
        {
            if(empty($this->config['action']))
            {
                throw new Exception('EAjaxUpload: param "action" cannot be empty.');
            }

            if(empty($this->config['allowedExtensions']))
            {
                throw new Exception('EAjaxUpload: param "allowedExtensions" cannot be empty.');
            }

            if(empty($this->config['sizeLimit']))
            {
                throw new Exception('EAjaxUpload: param "sizeLimit" cannot be empty.');
            }

            unset($this->config['element']);
        }

        echo '<div><noscript><p>Please enable JavaScript to use file uploader.</p></noscript></div>';

        $assets = new Asset();
        if($this->css) $assets->css = [$this->css];
        $assets::register($this->view);

    }

    public function run()
    {
        if($this->initOnly) return;

		$postParams = array('id'=>$this->id, 'upload-type'=>$this->config['uploadType'], 'session_id'=>Yii::$app->session->id, Yii::$app->request->csrfParam=>Yii::$app->request->getCsrfToken());
	    $postParams = array_merge($postParams, $this->postParams);
	
		$config = [
			'element'=>'js:document.getElementById("'.$this->id.'")',
			'debug'=>false,
			'multiple'=>true,
		   ];
    
        $config = array_merge($config, $this->config);
		$config['params'] = $postParams;
		$config = \yii\helpers\Json::encode($config);
        echo '<script>
        $(document).ready(function(){
        	QQFileUploaderConfig["'.$this->id.'"] = '.$config.';
       		initQQUploader("'.$this->id.'");	
        });
        </script>';        
	}
}