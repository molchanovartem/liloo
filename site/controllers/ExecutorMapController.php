<?php

namespace site\controllers;

use site\services\ExecutorService;

/**
 * Class ExecutorMapController
 *
 * @package site\controllers
 */
class ExecutorMapController extends Controller
{
    /**
     * ExecutorController constructor.
     * @param string $id
     * @param $module
     * @param ExecutorService $executorService
     * @param array $config
     */
    public function __construct(string $id, $module, ExecutorService $executorService, array $config = [])
    {
        $this->modelService = $executorService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->extraRender('index');
    }

    public function actionCatalogData()
    {
        $this->modelService->index();

        return $this->asJson($this->modelService->getData());
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionUserView($id)
    {
        $this->modelService->findUser($id);

        return $this->extraRender('userView', ['data' => $this->modelService->getData()]);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionSalonView($id)
    {
        $this->modelService->findSalon($id);

        return $this->extraRender('salonView', ['data' => $this->modelService->getData()]);
    }
}