<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

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
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'RU', 'items' => [['label' => 'Русский', 'url' => 'lang=ru'],
            '<li class="divider"></li>',
            ['label' => 'English', 'url' => 'lang=en'],
        ]
        ],
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'Personal Area', 'url' => ['/office/office']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
        <div class="container simply-body">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="#" class="site_title">
                                <img src="/frontend/web/images/logo-icon.png" alt="">
                                <span>Your Site</span>
                            </a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="<?= $this->context->path.$this->context->image?>" alt="avatar" class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Добро пожаловать,</span>
                                <h2><?= $this->context->username; ?></h2>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br>

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section active">
                                <ul class="nav side-menu" style="">
                                    <li class="active  current-page">
                                        <?= Html::a('Кабинет','office', ['class' => 'fa fa-home fa-fw']) ?>
                                    </li>
                                    <li class="">
                                        <?= Html::a('Мои инвестиции','deposits', ['class' => 'fa fa-bank fa-fw']) ?>
                                    </li>
                                    <li class="">
                                        <?= Html::a('Пополнить баланс','payin', ['class' => 'fa fa-briefcase fa-fw']) ?>
                                    </li>
                                    <li class="">
                                        <?= Html::a('Вывод средств','payout', ['class' => 'fa fa-refresh fa-fw']) ?>
                                    </li>
                                    <li class="">
                                        <?= Html::a('История операций','operations', ['class' => 'fa fa-calendar fa-fw']) ?>
                                    </li>
                                    <li class="">
                                        <?= Html::a('Партнерская программа','refsys', ['class' => 'fa fa-users fa-fw']) ?>
                                    </li>
                                    <!--                                <li class="">-->
                                    <!--                                    <a>-->
                                    <!--                                        <i class="fa fa-paper-plane-o fa-fw" aria-hidden="true"></i>Рекламные материалы-->
                                    <!--                                    </a>-->
                                    <!--                                    <ul class="nav child_menu">-->
                                    <!--                                        <li><a href="#">Лендинги</a></li>-->
                                    <!--                                        <li><a href="#">Баннеры</a></li>-->
                                    <!--                                        <li><a href="#">Презентация</a></li>-->
                                    <!--                                    </ul>-->
                                    <!--                                </li>-->
                                    <li class="">
                                        <?= Html::a('Профиль','profile', ['class' => 'fa fa-user fa-fw']) ?>
                                    </li>
                                    <li>

                                        <a href="#">
                                            <i class="fa fa-sign-out fa-fw"></i>Выход
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <!-- /sidebar menu -->
                    </div>
                </div>
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <ul class="nav navbar-nav navbar-right simply-nav">
                                <li>
                                    <a style="min-width: 550px" class="pull-right">
                                        <span class="pull-left" style="margin-top: 5px">Ваша партнерская ссылка:&nbsp;</span>
                                        <div class="input-group" style="margin: 0; max-width: 350px">
                                            <div class="input-group-addon">
                                                <i class="fa fa-group fa-fw"></i>
                                            </div>
                                            <input type="text" id="referalUrl" name="ref-link" value="https://yoursite/?ref=simply87" class="form-control" onclick="select()" style="background: #ccc; border-top-right-radius: 3px; border-bottom-right-radius: 3px">
                                        </div>
                                    </a>
                                </li>
                            </ul>

                        </nav>
                    </div>
                </div>
                <div class="right_col" role="main" style="min-height: 819px;">
                    <div class="row tile_count">
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-balance-scale"></i> Баланс</span>
                            <div class="count green">
                                <div class="amount">
                                    $0
                                    <br>
                                    <span>฿</span>0
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-clock-o"></i> Вклад</span>
                            <div class="count">
                                <div class="amount">
                                    <?= '$'.$this->context->payin; ?>
                                    <br>
                                    <span><?= '฿'.$this->context->bit_price_in; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-money"></i> Доход с депозита</span>
                            <div class="count">
                                <div class="amount">
                                    <?= '$'.$this->context->in_fr_deposit; ?>
                                    <br>
                                    <span><?= '฿'.$this->context->bit_price_dep; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Партнерские</span>
                            <div class="count">
                                <div class="amount">
                                    $0
                                    <br>
                                    <span>฿</span>0
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Выведено</span>
                            <div class="count">
                                <div class="amount">
                                    <?= '$'.$this->context->payout; ?>
                                    <br>
                                    <span><?= '฿'.$this->context->bit_price_out; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title" style="border-bottom: 0">
                                <h2>Статистика доходов</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <div class="btn-group btn-stats" role="group">
                                        <button type="button" class="btn btn-default" value="perc">Проценты</button>
                                        <button type="button" class="btn btn-default" value="month">Месяц</button>
                                        <button type="button" class="btn btn-primary" value="day">День</button>
                                    </div>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="echarts" style="height: 400px; -webkit-tap-highlight-color: transparent; user-select: none; background: transparent;" _echarts_instance_="ec_1509361632975"><div style="position: relative; overflow: hidden; width: 1013px; height: 400px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas width="1013" height="400" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 1013px; height: 400px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="depo">
                        <div class="col-md-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Депозиты</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    У вас <b>нет депозитов</b>
                                    <br>
                                    <br>


                                    <a href="#" class="btn btn-primary">Сделать депозит</a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

<style>
    .simply-body{
        margin-top: 70px;
    }
</style>
<footer class="site-footer wow fadeInUp">
    <div class="container">

        <div class="row">
            <div class="col-md-6">

                <div class=" branding">
                    <img src="/frontend/web/images/logo-footer.png" alt="Site title" class="logo-icon">
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
