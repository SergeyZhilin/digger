<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>

    <br><!-- Убрать перед аплойдем  -->
    <br><!-- Убрать перед аплойдем  -->
    <br><!-- Убрать перед аплойдем  -->

<?= $form->field($model,'username')->textInput(['autofocus'=>true]) ?>


<?= $form->field($model,'email')->textInput(['autofocus'=>true]) ?>


<?= $form->field($model,'password')->passwordInput()?>

    <div class="form-group">
        <div>
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>