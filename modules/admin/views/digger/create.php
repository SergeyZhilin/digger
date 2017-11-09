<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Digger */

$this->title = 'Create Digger';
$this->params['breadcrumbs'][] = ['label' => 'Diggers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="digger-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
