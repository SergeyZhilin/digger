<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/animate.css',
        'css/simply.css',
        'style.css',
        'fonts/font-awesome.min.css',
    ];
    public $js = [
        'js/ie-support/html5.js',
        'js/ie-support/respond.js',
        'js/jquery-1.11.1.min.js',
        'js/plugins.js',
        'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
