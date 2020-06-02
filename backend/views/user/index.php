<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'name',
            'second_name',
            [
                'attribute' => 'position',
                'value' => function ($model) {
                    return \common\models\User::getPositionNames($model->position);
                }
            ],
            [
                'attribute' => 'region_id',
                'label' => 'Region',
                'value' => function ($model) {
                    return $model->region->name;
                }
            ],

            ['class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        if ($model->position != \common\models\User::POSITION_DIRECTOR) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('app', 'Șterge'),
                                'data-confirm' => Yii::t('app', 'Sigur doriți să ștergeți?'),
                                'data-method' => 'post',
                                'access' => 'delete',
                                'visible' => Yii::$app->user->can(Yii::$app->id . Yii::$app->controller->id . '/delete'),
                                'data-pjax' => '0',
                            ]);
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
                ]
            ]
        ],
    ]); ?>


</div>
