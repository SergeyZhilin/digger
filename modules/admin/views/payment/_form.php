<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Payment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'in_fr_deposit')->textInput() ?>

    <?= $form->field($model, 'payin')->textInput() ?>

    <?= $form->field($model, 'time_payin')->textInput() ?>

    <?= $form->field($model, 'payout')->textInput() ?>

    <?= $form->field($model, 'time_payout')->textInput() ?>

    <?= $form->field($model, 'current_amount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
