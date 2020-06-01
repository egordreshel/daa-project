<?php

use yii\helpers\Html;

?>



<?= Html::beginForm(['time','id' => $model->id], 'POST', ['enctype' => 'multipart/form-data']); ?>
<?= Html::label('Add/Remove time'); ?>
<div class="row">
    <?= Html::radioList('radio', [0,1], [1 => 'Add', 0 => 'Remove']) ?>
</div>

<?= Html::input('number', 'time') ?>
<br><br>
<div class="form-group">
    <?= Html::submitButton('Accept', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
</div>
<?= Html::endForm(); ?>

