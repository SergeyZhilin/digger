<?php

$this->title = 'Office';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->user->isGuest) {
    return Yii::$app->response->redirect('login');
}

?>

    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
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
                                <li class="">
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
                                    <li><a href="#"> Profile</a></li>
                                    <li><a href="#"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
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

                <script src="/js/echarts.min.js"></script>
                <script src="/js/echart-stats.js"></script>

                <div class="clearfix"></div></div></div></div>


<?php
//$form = ActiveForm::begin(['class' => 'form-horisontal']);
//?>
<!---->
<!---->
<?php
//ActiveForm::end();
//?>