<?php
namespace demonId\ajaxFileUploader\actions;

use Yii;
use yii\base\Action;
use demonId\ajaxFileUploader\qqFileUploader;
use yii\helpers\Html;

class UploadFileAction extends Action
{
    public $modelName;

    public function run()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $uploadsModel = $this->modelName;

        $id = Yii::$app->request->get('id', null);
//        if($_REQUEST['session_id']!=Yii::$app->session->id) Yii::$app->end();

        if (isset($_GET['qqfile'])) $file_name = $_GET['qqfile'];
        if (isset($_FILES['qqfile'])) $file_name = $_FILES['qqfile']['name'];
		if (isset($_REQUEST['file_name'])) $file_name = $_REQUEST['file_name'];

        $uploadSettings = $uploadsModel::uploadSettings($_REQUEST['upload-type']);

        $file_name_arr = pathinfo($file_name);

        $tmp_file = new $uploadsModel;
        $tmp_file->file_extention = $file_name_arr['extension'];
        $tmp_file->file_realname = substr($file_name, 0, (strlen($file_name) - strlen($file_name_arr['extension'])-1));
        $tmp_file->file_path = $uploadSettings['uploadPath'];
        if($tmp_file->saveTmpFile())
        {
            $new_file_name = $tmp_file->file_name.'.'.strtolower($tmp_file->file_extention);

            if (isset($_GET['qqfile'])) $_GET['qqfile'] = $new_file_name;
            if (isset($_FILES['qqfile'])) $_FILES['qqfile']['name'] = $new_file_name;
			if (isset($_REQUEST['file_name'])) $_REQUEST['file_name'] = $new_file_name;

            $allowedExtensions = $uploadSettings['allowedExtensions'];
            $sizeLimit = $uploadSettings['sizeLimit'];
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload(Yii::getAlias('@root').$uploadsModel::TMP_FILE_PATH);

            $uploadSettings['imageMinWidth'] = (isset($uploadSettings['imageMinWidth'])) ? $uploadSettings['imageMinWidth'] : 0;
            $uploadSettings['imageMinHeight'] = (isset($uploadSettings['imageMinHeight'])) ? $uploadSettings['imageMinHeight'] : 0;
            $uploadSettings['imageMaxWidth'] = (isset($uploadSettings['imageMaxWidth'])) ? $uploadSettings['imageMaxWidth'] : 0;
            $uploadSettings['imageMaxHeight'] = (isset($uploadSettings['imageMaxHeight'])) ? $uploadSettings['imageMaxHeight'] : 0;
            $image_error = '';

            if($tmp_file->file_type==$uploadsModel::FILE_TYPE_IMAGE)
            {
                if($uploadSettings['imageMinWidth']>0 || $uploadSettings['imageMinHeight']>0)
                {
                    $image_info = getimagesize(Yii::getAlias('@root').$tmp_file->getFileUrl());
                    if($uploadSettings['imageMinWidth']>0 && $image_info[0]<$uploadSettings['imageMinWidth']) $image_error .= 'min. width must be more than'.' '.$uploadSettings['imageMinWidth'].'px';
                    if($uploadSettings['imageMinHeight']>0 && $image_info[1]<$uploadSettings['imageMinHeight'])
                    {
                        if(strlen($image_error)>0) $image_error .= ', ';
                        $image_error .= 'min. height must be more than'.' '.$uploadSettings['imageMinHeight'].'px';
                    }
                }

                if($uploadSettings['imageMaxWidth']>0 || $uploadSettings['imageMaxHeight']>0)
                {
                    $image_info = getimagesize(Yii::getAlias('@root').$tmp_file->getFileUrl());
                    if($uploadSettings['imageMaxWidth']>0 && $image_info[0]>$uploadSettings['imageMaxWidth']) $image_error .= 'max. width must be less than'.' '.$uploadSettings['imageMaxWidth'].'px';
                    if($uploadSettings['imageMaxHeight']>0 && $image_info[1]>$uploadSettings['imageMaxHeight'])
                    {
                        if(strlen($image_error)>0) $image_error .= ', ';
                        $image_error .= 'max. height must be less than'.' '.$uploadSettings['imageMaxHeight'].'px';
                    }
                }

                if(strlen($image_error)>0) $image_error = 'Image dimensions is wrong'.': '.$image_error;
            }
            if(!isset($result['error']) && strlen($image_error)>0) $result['error'] = $image_error;

            $video_error = '';
            if(
                $tmp_file->file_type==$uploadsModel::FILE_TYPE_VIDEO &&
                $tmp_file->file_extention!='flv' &&
                isset($uploadSettings['forceFlv']) &&
                $uploadSettings['forceFlv']===true
            )
            {
                $video_error = 'This video type is not supported.';
                $file = Yii::getAlias('@root').$tmp_file->getFileUrl(array('flv_video'=>false));
                $file_flv = Yii::getAlias('@root').$tmp_file->getFileUrl();
                if($file_flv)
                {
                    $tmp_file->file_extention = 'flv';
                    if($tmp_file->save())
                    {
                        $video_error = '';
                        if(file_exists($file) && !is_dir($file)) unlink($file);
                    }
                }
            }
            if(!isset($result['error']) && strlen($video_error)>0) $result['error'] = $video_error;

            if(isset($_REQUEST['imageCropRatio']) && $tmp_file->file_type==$uploadsModel::FILE_TYPE_IMAGE)
            {
                list($width, $height) = explode(',', $_REQUEST['imageCropRatio']);
                $tmp_file->setImageCropRatio($width, $height);
            }

            $result['id'] = $id;
            $result['file_id'] = Html::encode($tmp_file->id);
            $result['file_secret'] = Html::encode($tmp_file->secret);
            $result['file_url'] = Html::encode($tmp_file->getFileUrl(array('crop_image'=>false)));
            $result['file_name'] = Html::encode($file_name);
            $result['file_size'] = Html::encode(filesize(Yii::getAlias('@root').$tmp_file->getFileUrl(array('crop_image'=>false))));

            if(isset($result['error']) && count($result['error'])>0) $result['success'] = false;
            // to pass data through iframe you will need to encode all html tags
            $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $result;
        }
    }
}