<?php

namespace site\controllers;

use admin\models\AdminNotice;
use Yii;
use yii\filters\AccessControl;
use site\services\RecallService;

/**
 * Class RecallController
 * @package site\controllers
 */
class RecallController extends Controller
{
    /**
     * @return array
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
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
     * RecallController constructor.
     * @param string $id
     * @param $module
     * @param RecallService $recallService
     * @param array $config
     */
    public function __construct(string $id, $module, RecallService $recallService, array $config = [])
    {
        $this->modelService = $recallService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return array|string
     */
    public function actionIndex()
    {
        $this->modelService->gerRecalls();

        return $this->extraRender('/recall/index', ['data' => $this->modelService->getData()]);
    }

    /**
     * @param $accountId
     * @param $appointmentId
     * @param $assessment
     * @param $text
     * @return \yii\web\Response
     * @throws \api\graphql\errors\AttributeValidationError
     */
    public function actionCreate($accountId, $appointmentId, $assessment, $text)
    {
       $this->modelService->createRecall($accountId, $appointmentId, $assessment, $text);

        return $this->asJson($this->modelService->getData());
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->modelService->deleteRecall($id);
    }

    public function actionComplaint()
    {
        $this->modelService->complaint();
    }
}
