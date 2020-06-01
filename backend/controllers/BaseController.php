<?php


namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class BaseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     * @throws ForbiddenHttpException
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {

        if (Yii::$app->user->isGuest) {
            if ($action->id != 'login') {
                return $this->redirect(['/site/login']);
            }
        }
        // Rbac проверка доступов.
        if (parent::beforeAction($action)) {
            $resourcePath = Yii::$app->id . '/' . Yii::$app->controller->id . '/' . $action->id;
            if (!Yii::$app->user->can($resourcePath)) {
                throw new ForbiddenHttpException('Доступ запрёщен');
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Страница не найдена.
     * @param string $message сообщение об ошибке.
     * @throws NotFoundHttpException
     */
    protected function notFound($message = 'Not found')
    {
        throw new NotFoundHttpException($message);
    }


}