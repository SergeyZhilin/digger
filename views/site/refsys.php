<?php

$this->title = 'Referal System';
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
                            <li class="active  current-page">
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
        <div class="right_col" role="main" style="min-height: 703px;">
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
            <div class="row balance">
                <div class="col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Партнерские</h2>
                            <div class="clearfix">

                            </div>
                        </div>
                        <div class="x_content">
                            <div class="block_form">
                                <form method="post" name="refsys_frm"><!--  -->
                                    <div class="block_form_el cfix">
                                        <h2 for="refsys_frm_RefURL">Ваша ссылка для приглашений</h2>
                                    </div>
                                    <div id="ref-share-box" class="col-md-6" style="height: 57px;">
                                        <div class="form-group">
                                            <div class="col-sm-12 p-b-20">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-group fa-fw"></i>
                                                    </div>
                                                    <input type="text" id="referalUrl" name="ref-link" value="https://yoursite/?ref=simply87" class="form-control" onclick="select()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="clearfix"></div>
                                <div>
                                    <table class=" table stacktable small-only">
                                        <tbody>
                                        <tr class="">
                                            <td class="st-key">Пользователь</td>
                                            <td class="st-val ">Пользователь</td>
                                        </tr>
                                        <tr class="">
                                            <td class="st-key">Email</td>
                                            <td class="st-val ">Email</td>
                                        </tr>
                                        <tr class="">
                                            <td class="st-key">Дата регистрации</td>
                                            <td class="st-val ">Дата регистрации</td>
                                        </tr>
                                            <tr class="">
                                                <td class="st-key">Депозит USD</td>
                                                <td class="st-val ">Депозит USD</td>
                                            </tr>
                                        <tr class="">
                                            <td class="st-key">Депозит BTC</td>
                                            <td class="st-val ">Депозит BTC</td>
                                        </tr>
                                        <tr class="">
                                            <td class="st-key">Сумма</td>
                                            <td class="st-val ">Сумма</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class=" table stacktable small-only">
                                        <tbody>
                                        <tr class="">
                                            <td class="st-key">Пользователь</td>
                                            <td class="st-val tab opened">Уровень 1</td>
                                        </tr>
                                        <tr class="">
                                            <td class="st-key">Email</td>
                                            <td class="st-val tab">Уровень 2</td>
                                        </tr>
                                        <tr class="">
                                            <td class="st-key">Дата регистрации</td>
                                            <td class="st-val tab">Уровень 3</td>
                                        </tr>
                                        <tr class="">
                                            <td class="st-key">Депозит USD</td>
                                            <td class="st-val tab">Уровень 4</td>
                                        </tr>
                                        <tr class="">
                                            <td class="st-key">Депозит BTC</td>
                                            <td class="st-val tab">Уровень 5</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <table id="card-table" cellspacing="0" cellpadding="0" border="0" class="table stacktable large-only">
                                    <tbody>
                                    <tr>
                                        <th>Пользователь</th>
                                        <th>Email</th>
                                        <th>Дата регистрации</th>
                                        <th>Депозит USD</th>
                                        <th>Депозит BTC</th>
                                        <th>Сумма</th>
                                    </tr>
                                    <tr>
                                        <td id="tab" class="tab" data-id="1" colspan="6" align="center" bgcolor="#34495e" style="color: #fff">Уровень 1</td>
                                        <td id="tab" class="tab" data-id="2" colspan="6" align="center" bgcolor="#34495e" style="color: #fff">Уровень 2</td>
                                        <td id="tab" class="tab" data-id="3" colspan="6" align="center" bgcolor="#34495e" style="color: #fff">Уровень 3</td>
                                        <td id="tab" class="tab" data-id="4" colspan="6" align="center" bgcolor="#34495e" style="color: #fff">Уровень 4</td>
                                        <td id="tab" class="tab" data-id="5" colspan="6" align="center" bgcolor="#34495e" style="color: #fff">Уровень 5</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input name="__Cert" value="6842e12a" type="hidden">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix">

            </div>
        </div>
    </div>
</div>