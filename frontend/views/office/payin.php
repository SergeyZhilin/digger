<?php

$this->title = 'Pay In';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->user->isGuest) {
    return Yii::$app->response->redirect('login');
}

?>

<div class="container-simply body">
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
                        <span>Welcome,</span>
                        <h2><?= $this->context->username; ?></h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- /menu profile quick info -->

                <br>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <ul class="nav side-menu" style="">
                            <li class="">
                                <a href="office">
                                    <i class="fa fa-home fa-fw"></i>Кабинет
                                </a>
                            </li>
                            <li class="">
                                <a href="deposits">
                                    <i class="fa fa-bank fa-fw"></i>Мои инвестиции
                                </a>
                            </li>
                            <li class="active  current-page">
                                <a href="payin">
                                    <i class="fa fa-briefcase fa-fw"></i>Пополнить баланс
                                </a>
                            </li>
                            <li class="">
                                <a href="payout">
                                    <i class="fa fa-refresh fa-fw"></i>Вывод средств
                                </a>
                            </li>
                            <li class="">
                                <a href="operations">
                                    <i class="fa fa-calendar fa-fw"></i>История операций
                                </a>
                            </li>
                            <li class="">
                                <a href="refsys">
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
                                <a href="profile">
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
                <div class="col-md-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Пополнить баланс</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">


                            <form method="post" name="add">
                                <input name="Oper" id="add_Oper" value="CASHIN" type="hidden">
                                <div class="form-group">
                                    <label for="">Валюта счета<span class="descr_star">*</span></label>
                                    <div class="block_form_el_right">
                                        <select class="form-control" name="Curr" id="add_Curr">
                                            <option selected="" value="0">- выбор -</option>
                                            <option value="USD">USD</option>
                                            <option value="BTC">BTC</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Сумма<span class="descr_star">*</span></label>
                                    <div class="block_form_el_right">
                                        <input class="form-control" name="Sum" id="add_Sum" value="" type="text">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">С платежной системы<span class="descr_star">*</span></label>
                                    <div class="block_form_el_right">
                                        <select name="PSys" id="add_PSys" class="form-control">
                                            <option selected="" value="0">- выбор -</option>
                                            <option value="1" id="USD">Advanced Cash</option>
                                            <option value="4" id="USD">Perfect Money</option>
                                            <option value="5" id="BTC">Bitcoin</option>
                                        </select>
                                    </div>
                                </div>


                                <br>
                                <div class="form-group">
                                    <input name="__Cert" value="84e08025" type="hidden">
                                    <input name="add_btn" value="Создать" type="submit" class="btn btn-primary">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Информация</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <ul class="list-group">
                                <li class="list-group-item">Минимальный ввод от $10 и ฿ 0.05</li>
                            </ul>
                            <h4>* Если не получается пополнить через Advcash, попробуйте обновить браузер до новой версии или смените и повторите операцию.</h4>
                            <h4>* Для пополнения в Bitcoin создайте заявку и переведите заявленную сумму на кошелек «Получатель»</h4>
                            <h4>* После 3 подтверждённых транзакций от Blockchain деньги на баланс зачисляются от 1 до 24 часов.</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div></div></div></div>