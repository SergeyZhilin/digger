<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;

/**
 * Uploads controller
 */
class UploadsController extends MainController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['*'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = ($action->id !== "upload-file");
        return parent::beforeAction($action);
    }

    public function actions() {
        return [
            'upload-file' => [
                'class' => '\demonId\ajaxFileUploader\actions\UploadFileAction',
                'modelName' => \app\models\fileuploads\FileUploads::className()
            ],
            'download-file' => [
                'class' => '\demonId\ajaxFileUploader\actions\DownloadFileAction',
                'modelName' => \app\models\fileuploads\FileUploads::className()
            ],
        ];
    }
}
