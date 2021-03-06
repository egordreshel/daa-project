<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Prisoners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'second_name',
            [
                'attribute' => 'region_id',
                'label' => 'Region',
                'value' => function ($model) {
                    return $model->region->name;
                }
            ],
            'time',
            ['label' => 'Penalty',
                'value' => function ($model) {
                    $result = '';
                    foreach ($model->prisonerActivities as $activity) {
                        $result .= $activity->penalty . "\n";
                    }
                    return $result;
                }],
            ['label' => 'Privileges',
                'value' => function ($model) {
                    $result = '';
                    foreach ($model->prisonerActivities as $activity) {
                        $result .= $activity->privileges . "\n";
                    }
                    return $result;
                }],
        ]
    ]) ?>

</div>
