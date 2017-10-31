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
        'web/assets/3e3f2e0e/css/bootstrap.css',
        'web/diggerstyle/fonts/font-awesome.min.css',
        'web/diggerstyle/css/animate.css',
        'web/diggerstyle/style.css',
    ];
    public $js = [
        'web/diggerstyle/js/jquery-1.11.1.min.js',
        'web/diggerstyle/js/plugins.js',
        'web/diggerstyle/js/app.js',
        'web/assets/8e84304d/yii.validation.js',
        'web/assets/8e84304d/yii.activeForm.js',
        'web/assets/142e282a/jquery.js',
        'web/assets/3e3f2e0e/js/bootstrap.js',
        'web/assets/8e84304d/yii.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
