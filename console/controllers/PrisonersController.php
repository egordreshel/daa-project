<?php

namespace console\controllers;

use common\models\User;

use yii\base\Exception;
use yii\helpers\Console;

/**
 * Служебные действия приложения.
 * @package console\controllers
 */
class PrisonersController extends \yii\console\Controller
{
    /**
     * Генерация админа по умолчанию.
     * @return void
     */
    public function actionAddTime()
    {
       $prisoners = User::find()->where(['position' => User::POSITION_PRISONER])->all();
       foreach ($prisoners as $prisoner){
           $prisoner->time += 1800;
           if ($prisoner->save()){
               echo  $prisoner->id . 'added 1800 seconds';
           }
       }
    }
}
