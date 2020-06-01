<?php

namespace common\components\behaviors;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

/**
 * Rbac проверка доступов.
 */
class RbacControl extends ActionFilter
{
    /**
     * Инициализация.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Действия перед экшеном.
     * @param Action $action the action to be executed.
     * @return bool
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $resourcePath = '';
            $resourcePath .= Yii::$app->id . '/';
            // Проверка на отдельный модуль.
            $resourcePath .= Yii::$app->controller->module->id != Yii::$app->id ? Yii::$app->controller->module->id . '/' : '';
            $resourcePath .= Yii::$app->controller->id . '/' . $action->id;
            // Если у пользователя нет прав на этот путь.
            if (!Yii::$app->user->can($resourcePath)) $this->_denyAccess();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Запрет доступа.
     * @throws ForbiddenHttpException.
     */
    protected function _denyAccess()
    {
        throw new ForbiddenHttpException('Доступ запрещен!');
    }
}
