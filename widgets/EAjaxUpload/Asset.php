<?php
namespace demonId\ajaxFileUploader;

class Asset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/widgets/EAjaxUpload/assets';

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $css = [
        'fileuploader.css'

    ];
    public $js = [
        'fileuploader.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
