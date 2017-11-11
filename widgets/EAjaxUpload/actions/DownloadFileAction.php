<?php
namespace demonId\ajaxFileUploader\actions;

use Yii;
use yii\base\Action;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;

class DownloadFileAction extends Action
{
    public $modelName;

    public function run()
    {
        $uploadsModel = $this->modelName;

        $secret = Yii::$app->request->getBodyParam('secret', null);

        $file = $uploadsModel::findOne(['secret'=>$secret]);
        if(!$file) throw new BadRequestHttpException(404);

        $file_url = Yii::getAlias('@root').$file->getFileUrl();

        if (file_exists($file_url))
        {
	        return Yii::$app->response->sendFile($file_url, basename(Html::encode(str_replace(array(' ', ','), array('_', ''), $file->file_realname)).'.'.$file->file_extention));
        }

        Yii::$app->end();
    }
}