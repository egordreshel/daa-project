<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prisoners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Prisoner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'second_name',
            [
                'attribute' => 'region_id',
                'value' => function ($model) {
                    return $model->region->name;
                }
            ],
            ['attribute' => 'time',
                'value' => function ($model) {
                    return $model;
                }
            ],


            ['class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {activity} {time}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        if (Yii::$app->user->can(Yii::$app->id . '/' . Yii::$app->controller->id . '/delete')) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('app', 'Șterge'),
                                'data-confirm' => Yii::t('app', 'Sigur doriți să ștergeți?'),
                                'data-method' => 'post',
                                'access' => 'delete',
                                'visible' => Yii::$app->user->can(Yii::$app->id . Yii::$app->controller->id . '/delete'),
                                'data-pjax' => '0',
                            ]);
                        } else {
                            return null;
                        }
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'View',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => 'Update',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                    'activity' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-sort"></span>', ['prisoner-activity/index', 'prisoner_id' => $model->id], [
                            'title' => 'activity',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                    'time' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-time"></span>', ['prisoner/time', 'id' => $model->id], [
                            'title' => 'activity',
                            'data-pjax' => '0',
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>


</div>
