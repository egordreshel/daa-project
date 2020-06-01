<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PrisonerActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prisoner-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prisoner_id')->textInput() ?>

    <?= $form->field($model, 'penalty')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'privileges')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
