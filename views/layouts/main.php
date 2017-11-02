<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
//            ['label' => 'Home', 'url' => ['/site/index']],
//            ['label' => 'About', 'url' => ['/site/about']],
//            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'RU',
                'items' => [
                    ['label' => 'Русский', 'url' => 'lang=ru'],
                    '<li class="divider"></li>',
                    ['label' => 'English', 'url' => 'lang=en'],
                ],
                ],
            ['label' => 'Registration', 'url' => ['/site/signup']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<!--<footer class="footer">-->
<!--    <div class="container">-->
<!--        <p class="pull-left">&copy; My Company --><?//= date('Y') ?><!--</p>-->
<!---->
<!--        <p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
<!--    </div>-->
<!--</footer>-->
<footer class="site-footer wow fadeInUp">
    <div class="container">

        <div class="row">
            <div class="col-md-6">

                <div class=" branding">
                    <img src="web/diggerstyle/images/logo-footer.png" alt="Site title" class="logo-icon">
                    <h1 class="site-title"><a href="#">Company <span>Name</span></a></h1>
                    <h2 class="site-description">Tagline goes here</h2>
                </div> <!-- .branding -->

                <p class="copy">Copyright 2014 Company name. designed by Themezy. All rights reserved</p>
            </div>

            <div class="col-md-6 align-right">

                <nav class="footer-navigation">
                    <a href="#">News</a>
                    <a href="#">About us</a>
                    <a href="#">Services</a>
                    <a href="#">Contact</a>
                </nav> <!-- .footer-navigation -->

                <div class="social-links">
                    <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
                    <a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a>
                </div> <!-- .social-links -->

            </div>
        </div>

    </div>
</footer> <!-- .site-footer -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
