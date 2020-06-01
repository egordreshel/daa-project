<?php

/* @var $this yii\web\View */

use aneeshikmat\yii2\Yii2TimerCountDown\Yii2TimerCountDown;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $model common\models\User */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
    <br class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'second_name',
        'time',
        ['label' => 'Penalty',
            'value' => function ($model) {
                return $model->prisonerActivities->penalty;
            }],
        ['label' => 'Privileges',
            'value' => function ($model) {
                return $model->prisonerActivities->privileges;
            }],
    ],
]) ?>
<?php if ($model->time > 0): ?>
    <?= Html::button('Start', ['id' => 'start']) ?>
    <?= Html::button('Stop', ['id' => 'stop', 'class' => 'hidden']) ?>
<?php endif; ?>
<?php if ($model->time < 0): ?>
    <h1>You can't call</h1>
<?php endif; ?>
    <br><br>
    <br>
    <p>You have</p>
    <h2 id="demo"><?= $model->time ?></h2>
    <p>seconds</p>
    <br><br>
<?php $this->registerJs('
  var userId = ' . $model->id . ';      
'); ?>
<?php $this->registerJs(<<<JS
var idIntervals = 0;
$('#start').on('click', function() {
    var doUpdate = function() {
        $('#demo').each(function() {
        var count = parseInt($(this).html());
            if (count !== 0) {
                $(this).html(count - 1);
            }
        });
    };
    $('#stop').removeClass('hidden');
    idIntervals = setInterval(doUpdate, 1000);
})

$('#stop').on('click', function() {
    clearInterval(idIntervals);
     $.ajax({
          url: '/site/timer',
          type: 'POST',
          data: {time: $('#demo').text(), id: userId},
      });
});

JS
);
