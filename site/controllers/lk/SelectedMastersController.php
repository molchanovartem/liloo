<?php

namespace site\controllers\lk;

use Yii;
use site\services\lk\SelectedMastersService;

/**
 * Class SelectedMastersController
 *
 * @package site\controllers\lk
 */
class SelectedMastersController extends Controller
{
    /**
     * SelectedMastersController constructor.
     * @param string $id
     * @param $module
     * @param SelectedMastersService $selectedMastersService
     * @param array $config
     */
    public function __construct(string $id, $module, SelectedMastersService $selectedMastersService, array $config = [])
    {
        $this->modelService = $selectedMastersService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return array|string
     */
    public function actionIndex()
    {
        $this->modelService->index();

        return $this->extraRender('/lk/selectedMasters/index', ['data' => $this->modelService->getData()]);
    }

    /**
     * @param $executorId
     * @param $isSalon
     *
     * @return \yii\web\Response
     */
    public function actionAddToSelected($executorId, $isSalon)
    {
        $this->modelService->addToSelected($executorId, $isSalon);

        return $this->redirect(Yii::$app->request->referrer);
    }
}
