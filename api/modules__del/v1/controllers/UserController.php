<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;
use api\modules\v1\services\UserModelService;

class UserController extends Controller
{
    public function __construct(string $id, $module, UserModelService $modelService, array $config = [])
    {
        $this->modelService = $modelService;
        parent::__construct($id, $module, $config);
    }

    public function verbs()
    {
        return array_merge(parent::verbs(), [
            'profile' => ['get'],
            'profileUpdate' => ['put', 'patch'],
        ]);
    }

    /**
     * @param int $userId
     * @return null
     * @throws NotFoundHttpException
     */
    public function actionViewProfile($userId)
    {
        if (!$this->modelService->viewProfile($userId)) {
            throw new NotFoundHttpException();
        }

        return $this->modelService->getResult();
    }

    /**
     * @param $userId
     * @return null
     * @throws UnprocessableEntityHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdateProfile($userId)
    {
        $this->modelService->updateProfile($userId);

        return $this->modelService->getResult();
    }

    /**
     * @param $userId
     */
    public function actionAddSpecialization($userId)
    {
        Yii::$app->response->setStatusCode(204);

        if ($this->modelService->addSpecializations($userId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    /**
     * @param $userId
     */
    public function actionUpdateSpecialization($userId)
    {
        Yii::$app->response->setStatusCode(204);

        if ($this->modelService->updateSpecializations($userId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    /**
     * @param $userId
     * @param null $specializationId
     * @throws ServerErrorHttpException
     */
    public function actionDeleteSpecialization($userId, $specializationId = null)
    {
        if ($this->modelService->deleteSpecializations($userId, $specializationId)) {
            Yii::$app->response->setStatusCode(204);
        } else {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
    }

    /**
     * @param $userId
     */
    public function actionAddConvenience($userId)
    {
        Yii::$app->response->setStatusCode(204);

        if ($this->modelService->addConveniences($userId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    /**
     * @param $userId
     */
    public function actionUpdateConvenience($userId)
    {
        Yii::$app->response->setStatusCode(204);

        if ($this->modelService->updateConveniences($userId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    /**
     * @param $userId
     * @param null $convenienceId
     * @throws ServerErrorHttpException
     */
    public function actionDeleteConvenience($userId, $convenienceId = null)
    {
        if ($this->modelService->deleteConveniences($userId, $convenienceId)) {
            Yii::$app->response->setStatusCode(204);
        } else {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
    }
}