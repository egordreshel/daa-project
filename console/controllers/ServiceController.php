<?php

namespace console\controllers;

use common\models\Region;
use common\models\User;

use yii\base\Exception;
use yii\helpers\Console;

/**
 * Служебные действия приложения.
 * @package console\controllers
 */
class ServiceController extends \yii\console\Controller
{
    /**
     * Генерация админа по умолчанию.
     * @param $region_name
     * @param $username
     * @param $password
     * @return int
     * @throws Exception
     */
    public function actionDefaultAdmin($region_name, $username, $password)
    {
        if (User::findByUsername($username)) {
            Console::output('Пользователь уже создан');
            return self::EXIT_CODE_ERROR;
        }
        $zone = new Region([
            'name' => $region_name,
            'status' => Region::STATUS_MAIN
        ]);
        $zone->save(false);
        $user = new User([
            'username' => $username,
            'password' => $password,
            'name' => 'admin',
            'position' => 'director',
            'second_name' => 'director'
        ]);
        $user->generateAuthKey();

        if ($user->save(false)) {
            Console::output('Пользователь успешно создан');
            return self::EXIT_CODE_NORMAL;
        } else {
            Console::output('Не удалось создать пользователя');
            return self::EXIT_CODE_ERROR;
        }
    }

}
