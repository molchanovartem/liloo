<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\web\ServerErrorHttpException;
use api\modules\v1\services\SalonModelService;

/**
 * Class SalonController
 * @package api\controllers\v1
 */
class SalonController extends Controller
{
    public function __construct(string $id, $module, SalonModelService $modelService, array $config = [])
    {
        $this->modelService = $modelService;

        parent::__construct($id, $module, $config);
    }

    public function actionIndexUser($salonId)
    {
        $this->modelService->indexUsers($salonId);

        return $this->modelService->getResult();
    }

    public function actionAddUser($salonId)
    {
        if ($this->modelService->addUsers($salonId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    public function actionUpdateUser($salonId)
    {
        if ($this->modelService->updateUsers($salonId)) {
            Yii::$app->response->setStatusCode(204);
        }
    }

    public function actionDeleteUser($salonId, $userId = null)
    {
        if ($this->modelService->deleteUsers($salonId, $userId)) {
            Yii::$app->response->setStatusCode(204);
        } else {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
    }

    public function actionIndexUserService($salonId, $userId)
    {
        $this->modelService->indexUserServices($salonId, $userId);

        return $this->modelService->getResult();
    }

    public function actionAddUserService($salonId, $userId)
    {
        Yii::$app->response->setStatusCode(204);

        if ($this->modelService->addUserServices($salonId, $userId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    public function actionUpdateUserService($salonId, $userId)
    {
        Yii::$app->response->setStatusCode(204);

        if ($this->modelService->updateUserServices($salonId, $userId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    public function actionDeleteUserService($salonId, $userId, $serviceId = null)
    {
        if ($this->modelService->deleteUserServices($salonId, $userId, $serviceId)) {
            Yii::$app->response->setStatusCode(204);
        } else {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
    }

    public function actionIndexSpecialization($salonId)
    {
        $this->modelService->indexSpecializations($salonId);

        return $this->modelService->getResult();
    }

    public function actionAddSpecialization($salonId)
    {
        Yii::$app->response->setStatusCode(204);

        if ($this->modelService->addSpecializations($salonId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    public function actionUpdateSpecialization($salonId)
    {
        Yii::$app->response->setStatusCode(204);

        if ($this->modelService->updateSpecializations($salonId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    public function actionDeleteSpecialization($salonId, $specializationId = null)
    {
        if ($this->modelService->deleteSpecializations($salonId, $specializationId)) {
            Yii::$app->response->setStatusCode(204);
        } else {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
    }

    public function actionIndexConvenience($salonId)
    {
        $this->modelService->indexConveniences($salonId);

        return $this->modelService->getResult();
    }

    public function actionAddConvenience($salonId)
    {
        Yii::$app->response->setStatusCode(204);

        if ($this->modelService->addConveniences($salonId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    public function actionUpdateConvenience($salonId)
    {
        Yii::$app->response->setStatusCode(204);

        if ($this->modelService->updateConveniences($salonId)) {
            Yii::$app->response->setStatusCode(201);
        }
    }

    public function actionDeleteConvenience($salonId, $convenienceId = null)
    {
        if ($this->modelService->deleteConveniences($salonId, $convenienceId)) {
            Yii::$app->response->setStatusCode(204);
        } else {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
    }


}