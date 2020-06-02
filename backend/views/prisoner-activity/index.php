<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PrisonerActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prisoner Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prisoner-activity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Prisoner Activity', ['create','id' => $prisoner_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'prisoner_id',
            'penalty',
            'privileges',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
