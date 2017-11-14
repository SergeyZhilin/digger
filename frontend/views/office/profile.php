<?php

use yii\helpers\Html;
use \common\models\fileuploads\FileUploads;
use yii\widgets\ActiveForm;
//use EAjaxUpload;
use yii\helpers\Url;
use yii\web\JsExpression;
//use \common\models\fileuploads\ViewHelper;
//use \common\models\fileuploads\ImageHelper;

$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->user->isGuest) {
    return Yii::$app->response->redirect('login');
}

/**
 * @var $modelUser \common\models\User;
 */

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
                        <?= Html::img($modelUser->getUserpicUrl(), ['class'=>'img-circle profile_img']); ?>
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2><?= $this->context->users->username; ?></h2>
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
                                <a href="office">
                                    <i class="fa fa-home fa-fw"></i>Кабинет
                                </a>
                            </li>
                            <li class="">
                                <a href="deposits">
                                    <i class="fa fa-bank fa-fw"></i>Мои инвестиции
                                </a>
                            </li>
                            <li class="">
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
                            <li class="active  current-page">
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
                        <li role="presentation" class="active"><a href="profile">Профиль</a></li>
                        <li role="presentation"><a href="account">Безопасность</a></li>
                        <li role="presentation"><a href="changepass">Изменить пароль</a></li>
                        <li role="presentation"><a href="payments">Платежные реквизиты</a></li>
                        <li role="presentation"><a href="pin">PIN-Code</a></li>
                    </ul>
                    <div class="col-md-6 col-sm-6 col-xs-12 profile_left">
                        <div class="profile_img">
                            <div id="crop-avatar">
                                <!-- Current avatar -->

                                <?= Html::img($modelUser->getUserpicUrl(), ['class'=>'img-responsive avatar-view center-block', 'title'=>'Change the avatar']); ?>

                            </div>
                        </div>
                        <br>

                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'profile-form',
                            'enableClientValidation'=>false,
                            'validateOnSubmit'=>false,
                            'options' => ['class' => 'form-horizontal'],

                        ]);
                        echo Html::activeHiddenInput($modelUser, 'userpic_id', ['id'=>'userpic_id']);
                        ?>

                        <p class="text-center text-muted">
                            <?php
                            $userpic_settings = FileUploads::uploadSettings('userpic');

                            echo ' Supported file formats: '.implode(', ', $userpic_settings['allowedExtensions']).'.<br> Maximum file size : '.round($userpic_settings['sizeLimit']/1024/1024, 2).' MB';
                            ?>
                        </p>
<!--                        <div class="clearfix mb15">-->
<!--                            --><?//= Html::a('Upload a photo', '#', ['id'=>'uploadUserpic', 'class'=>'btn btn-primary pull-right']); ?>
<!--                            --><?php
//                            echo EAjaxUpload::widget([
//                                'id'=>'uploadUserpic',
//                                'config'=>\yii\helpers\ArrayHelper::merge(
//                                    FileUploads::uploadSettings('userpic'),
//                                    [
//                                        'action'=>Url::toRoute(['uploads/upload-file']),
//                                        'onComplete'=>new JsExpression("function(id, fileName, responseJSON){ if(typeof(responseJSON.error)=='undefined') setUserpic(responseJSON); }"),
//                                        'onSubmit'=>new JsExpression("function(id, fileName){ loadUserpic(); }"),
//                                        'messages'=>[
//                                            'typeError'=>'File format error. Supported formats: {extensions}',
//                                            'sizeError'=>'File is too big. Maximum file size: {sizeLimit}',
//                                        ],
//                                        'showMessage'=>new JsExpression("function(message){ errorUserpic(message); }")
//                                    ]
//                                ),
//                                'postParams'=>['imageCropRatio'=>'100,100']
//                            ]);
//                            ?>
<!--                            <a class="btn btn-gray--><?php //if(!$modelUser->userpic) echo ' hidden'; ?><!--" id="del-userpic" href="#">Delete photo</a>-->
<!--                        </div>-->

                        <div class="alert hidden" id="userpic-form-error">Upload file error:<ul><li></li></ul></div>

<!--                        <div id="userpic-image-frame" class="text-center mb15">-->
<!--                            --><?//= ViewHelper::imageCropForm('userpic', $modelUser->userpic, 300, 300); ?>
<!--                        </div>-->

                        <div id="userpic-load" class="text-center mb15 form-group hidden" ><img src="/images/loader-big.gif" /></div>

<!--                        <div class="text-center mb15 empty--><?php //if($modelUser->userpic) echo ' hidden'; ?><!--" id="userpic_empty">-->
<!--                            --><?php
//                            $src = ImageHelper::getPicture($modelUser->getDefaultUserpicUrl(), 216, 315);
//                            echo Html::img($src);
//                            ?>
<!--                        </div>-->


                        <?= $form->field($modelUser,'name')->textInput() ?>


                        <?= $form->field($modelUser,'surname')->textInput() ?>


                        <?= $form->field($modelUser,'username', ['inputOptions'=>[
                            'readonly'=> true
                        ]])->textInput()?>


                        <?= $form->field($modelUser,'email', ['inputOptions'=>[
                            'readonly'=> true
                        ]])->textInput()?>

                        <div class="form-group">
                            <div>
                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('body').on('click', '#del-userpic', function () {
                $('#userpic-frame').html('');
                $('#userpic_empty').removeClass('hidden');

                $(this).addClass('hidden');
                $('#userpic_id').attr('value', 0);

                $('#userpic-form-error').addClass('hidden');

                return false;
            });
        });
    </script>

</div>
