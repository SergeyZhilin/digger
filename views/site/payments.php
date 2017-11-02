<?php

$this->title = 'Payment Requisites';
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
        <div class="right_col" role="main" style="min-height: 744px;">
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
                    <h2>Платежные реквизиты</h2><div class="clearfix"></div></div><div class="x_content"><ul class="nav nav-tabs bar_tabs"><li role="presentation"><a href="/profile">Профиль</a></li><li role="presentation"><a href="/account">Безопасность</a></li><li role="presentation"><a href="/changepass">Изменить пароль</a></li><li role="presentation" class="active"><a href="/payments">Платежные реквизиты</a></li><li role="presentation"><a href="/pin">PIN-Code</a></li></ul><div class="col-md-6 col-xs-12"><form method="post" action="/balance/wallets" name="balance/wallets_frm"><div class="form-group"><label for="">Платежная система по-умолчанию</label><div class="block_form_el_right"><select name="DefCurr" id="balance/wallets_frm_DefCurr" class="form-control"><option value="0" selected="">- выбор -</option><option value="1" selected="selected">Advanced Cash</option><option value="4">Perfect Money</option><option value="5">Bitcoin</option><option value="6">Payeer</option></select></div></div><div class="form-group"><label for="">Advanced Cash</label><div class="block_form_el_right"><input name="AC[acc]" id="balance/wallets_frm_AC[acc]" value="" type="text" class="form-control"><small>sample@domain.zn</small></div></div><div class="form-group"><label for="">Perfect Money</label><div class="block_form_el_right"><input name="PM[acc]" id="balance/wallets_frm_PM[acc]" value="" type="text" class="form-control"><small>U1234567</small></div></div><div class="form-group"><label for="">Bitcoin</label><div class="block_form_el_right"><input name="IBC[acc]" id="balance/wallets_frm_IBC[acc]" value="" type="text" class="form-control"><small></small></div></div><div class="form-group"><label for="">Payeer</label><div class="block_form_el_right"><input name="PY[acc]" id="balance/wallets_frm_PY[acc]" value="" type="text" class="form-control"><small>P1234567</small></div></div><input name="__Cert" value="37a7378a" type="hidden"><input name="balance/wallets_frm_btn" value="Сохранить" type="submit" class="btn btn-info"></form></div></div><div class="clearfix"></div></div></div></div><!-- Bootstrap --><script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script><!-- FastClick --><script src="/vendors/fastclick/lib/fastclick.js"></script><!-- NProgress --><script src="/vendors/nprogress/nprogress.js"></script><script src="/vendors/bootstrap-fileinput/js/fileinput.min.js"></script><script src="/vendors/bootstrap-fileinput/js/locales/ru.js"></script><script src="/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script><!-- Custom Theme Scripts --><script src="/build/js/custom.min.js"></script><script src="/js/main.js"></script><script src="/js/stacktable.js"></script><script src="/js/jivosite.js"></script><script>$(document).ready(function(e) {e.preventDefault();});$('#card-table').cardtable();</script></div>