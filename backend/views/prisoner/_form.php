<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'second_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'token')->textInput() ?>
        </div>
        <?php if (count($regions) > 1): ?>
            <div class="col-sm-3">
                <?= $form->field($model, 'region_id')->dropDownList($regions, ['prompt' => 'Select region'])->label('Region') ?>
            </div>
        <?php else:?>
            <div class="col-sm-3">
        <?= $form->field($model, 'region_id')->dropDownList($regions, ['disabled' => 'disabled'])->label('Region') ?>            </div>
        <?php endif; ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
