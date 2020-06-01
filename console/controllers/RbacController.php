<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use common\components\rbac\UserGroupRule;

/**
 * Контроллер rbac доступов.
 */
class RbacController extends Controller
{
    /**
     * Получить роли.
     *
     * @return array
     */
    public static function roles()
    {
        return [
            'director' => 'Директор',
            'second_director' => 'Директоп филиала',
            'worker' => 'Работник',
            'prisoner' => 'Заключённый',
            'guest' => 'Гость'
        ];
    }

    /**
     * Инициализация доступов.
     *
     * @return int
     * @throws \Exception
     */
    public function actionInit()
    {
        Yii::$app->authManager->invalidateCache();
        $authManager = Yii::$app->authManager;
        $authManager->removeAll(); // Удаляем старые данные, чтобы не было конфликта (обязательно!).
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);

        foreach (static::roles() as $role => $description) {
            $$role = $authManager->createRole($role);
            $$role->ruleName = $userGroupRule->name;
            $authManager->add($$role);
            $$role->description = $description;
        }

        // Разрешения доступов по ролям (группам).
        $permission = [
            'guest' => [],
            'director' => [
                'backend/region/index',
                'backend/region/create',
                'backend/region/update',
                'backend/region/delete',
                'backend/region/view',
                'backend/zone/index',
                'backend/zone/create',
                'backend/zone/update',
                'backend/zone/delete',
                'backend/zone/view',
            ],
            'second_director' => [
                'backend/prisoner/index',
                'backend/prisoner/create',
                'backend/prisoner/update',
                'backend/prisoner/delete',
                'backend/prisoner/view',
                'backend/prisoner/time',
                'backend/prisoner-activity/index',
                'backend/prisoner-activity/create',
                'backend/prisoner-activity/update',
                'backend/prisoner-activity/delete',
                'backend/prisoner-activity/view',
                'backend/user/index',
                'backend/user/create',
                'backend/user/update',
                'backend/user/delete',
                'backend/user/view',
            ],
            'worker' => [
                'backend/prisoner/index',
                'backend/prisoner/create',
                'backend/prisoner/update',
                'backend/prisoner/delete',
                'backend/prisoner/view',
                'backend/prisoner/time',
                'backend/prisoner-activity/index',
                'backend/prisoner-activity/create',
                'backend/prisoner-activity/update',
                'backend/prisoner-activity/delete',
                'backend/prisoner-activity/view',
            ],
            'prisoner' => [
                'frontend/site/index'
            ],
        ];

        foreach ($permission as $role => $routes) {
            foreach ($routes as $route) {
                if (is_null($authManager->getPermission($route))) {
                    // Создается разрешение.
                    $permission = $authManager->createPermission($route);
                    // Добавление разрешения в Yii::$app->authManager.
                    $authManager->add($permission);
                }
                $authManager->addChild($authManager->getRole($role), $authManager->getPermission($route));
            }
        }

        $authManager->addChild($prisoner, $guest);
        $authManager->addChild($director, $second_director);
        $authManager->addChild($director, $worker);
        $authManager->addChild($second_director, $worker);
        $authManager->addChild($director, $prisoner);
        $authManager->addChild($director, $guest);

        $this->stdout("RBAC has been updated.\n", Console::FG_GREEN);

        return self::EXIT_CODE_NORMAL;
    }
}
