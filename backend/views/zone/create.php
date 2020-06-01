<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Zone */

$this->title = 'Create Prison';
$this->params['breadcrumbs'][] = ['label' => 'Prison', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zone-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
