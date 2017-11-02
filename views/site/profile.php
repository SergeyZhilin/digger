<?php

$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->user->isGuest) {
    return Yii::$app->response->redirect('login');
}

?>

<div class="container body"><div class="main_container"><div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="#" class="site_title">
                        <img src="/web/diggerstyle/images/logo-icon.png" alt="">
                        <span>Your Site</span>
                    </a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="/web/images/user.png" alt="avatar" class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
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
                            <li class="">
                                <a href="/office">
                                    <i class="fa fa-home fa-fw"></i>Кабинет
                                </a>
                            </li>
                            <li class="">
                                <a href="/deposits">
                                    <i class="fa fa-bank fa-fw"></i>Мои инвестиции
                                </a>
                            </li>
                            <li class="">
                                <a href="/payin">
                                    <i class="fa fa-briefcase fa-fw"></i>Пополнить баланс
                                </a>
                            </li>
                            <li class="">
                                <a href="/payout">
                                    <i class="fa fa-refresh fa-fw"></i>Вывод средств
                                </a>
                            </li>
                            <li class="">
                                <a href="/operations">
                                    <i class="fa fa-calendar fa-fw"></i>История операций
                                </a>
                            </li>
                            <li class="">
                                <a href="/refsys">
                                    <i class="fa fa-users fa-fw"></i>Партнерская программа
                                </a>
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
                            <li class="active  current-page">
                                <a href="/profile">
                                    <i class="fa fa-user fa-fw"></i>Профиль
                                </a>
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

                    <ul class="nav navbar-nav navbar-right">

                        <li>
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="/web/images/user.png" alt="avatar">
                                <?= $this->context->username; ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="/profile"> Profile</a></li>
                                <li><a href="/login?out"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                            </ul>
                        </li>
                        <li>
                            <a style="min-width: 550px" class="pull-right"><span class="pull-left">Ваша партнерская ссылка:&nbsp;</span><div class="input-group" style="margin: 0; max-width: 350px">
                                    <div class="input-group-addon"><i class="fa fa-group fa-fw"></i></div>
                                    <input type="text" id="referalUrl" name="ref-link" value="https://yoursite/?ref=simply87" class="form-control" onclick="select()" style="background: #ccc; border-top-right-radius: 3px; border-bottom-right-radius: 3px">
                                </div></a>

                        </li>
                    </ul>

                </nav>
            </div>
        </div>
        <div class="right_col" role="main" style="min-height: 837px;">
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

            <div class="x_panel">
                <div class="x_title">
                    <h2>Профиль</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul class="nav nav-tabs bar_tabs">
                        <li role="presentation" class="active"><a href="/profile">Профиль</a></li>
                        <li role="presentation"><a href="/account">Безопасность</a></li>
                        <li role="presentation"><a href="/changepass">Изменить пароль</a></li>
                        <li role="presentation"><a href="/payments">Платежные реквизиты</a></li>
                        <li role="presentation"><a href="/pin">PIN-Code</a></li>
                    </ul>
                    <div class="col-md-6 col-sm-6 col-xs-12 profile_left">
                        <div class="profile_img">
                            <div id="crop-avatar">
                                <!-- Current avatar -->
                                <img class="img-responsive avatar-view center-block" src="/web/images/user.png" alt="Avatar" title="Change the avatar">
                            </div>
                        </div>
                        <br>
                        <form method="post" action="/profile" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Выберите фотографию:</label>
                                <div class="file-input file-input-new">
                                    <div class="kv-upload-progress hide"><div class="progress">
                                            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                                                0%
                                            </div>
                                        </div></div>
                                    <div class="input-group file-caption-main">
                                        <div tabindex="500" class="form-control file-caption  kv-fileinput-caption">
                                            <div class="file-caption-name"></div>
                                        </div>

                                        <div class="input-group-btn">
<!--                                            <button type="button" tabindex="500" title="Очистить выбранные файлы" class="btn btn-default fileinput-remove fileinput-remove-button"><i class="glyphicon glyphicon-trash"></i>  <span class="hidden-xs">Удалить</span></button>-->
<!--                                            <button type="button" tabindex="500" title="Отменить текущую загрузку" class="btn btn-default hide fileinput-cancel fileinput-cancel-button"><i class="glyphicon glyphicon-ban-circle"></i>  <span class="hidden-xs">Отмена</span></button>-->
<!--                                            <button type="submit" tabindex="500" title="Загрузить выбранные файлы" class="btn btn-default fileinput-upload fileinput-upload-button"><i class="glyphicon glyphicon-upload"></i>  <span class="hidden-xs">Загрузить</span></button>-->
                                            <div tabindex="500" style="height: 34px" class="btn btn-primary btn-file">
                                                <i class="glyphicon glyphicon-folder-open"></i>&nbsp;
                                                <span class="hidden-xs">Выбрать …</span>
                                                <input id="logo-uploader-ru" style="display: none" type="file" name="logo">
                                            </div>
                                        </div>
                                    </div></div>
                            </div>
                        </form>
                        <form action="/profile" method="post">
                            <div class="form-group">
                                <label>Ваше Имя:</label>
                                <input type="text" name="name" value="" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Ваша Фамилия:</label>
                                <input type="text" name="lastname" value="" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Ваш Логин:</label>
                                <input type="text" value="<?= $this->context->username; ?>" class="form-control" readonly="">
                            </div>

                            <div class="form-group">
                                <label>Адрес електронной почты:</label>
                                <input type="text" value="<?= $this->context->users->email; ?>" class="form-control" readonly="">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-info" type="submit" name="profile">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script src="/js/profile.js"></script>

            <div class="clearfix"></div></div></div></div>
