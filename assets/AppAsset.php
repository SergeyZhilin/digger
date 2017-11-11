<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'web/css/simply.css',
        'web/diggerstyle/fonts/font-awesome.min.css',
        'web/diggerstyle/css/animate.css',
        'web/diggerstyle/style.css',
    ];
    public $js = [
        'web/diggerstyle/js/plugins.js',
        'web/diggerstyle/js/app.js',
        'web/js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
