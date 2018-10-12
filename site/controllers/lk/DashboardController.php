<?php

namespace site\controllers\lk;

use site\services\SiteService;

/**
 * Class DashboardController
 * @package site\controllers\lk
 */
class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     * @param string $id
     * @param $module
     * @param SiteService $dashboardService
     * @param array $config
     */
    public function __construct(string $id, $module, SiteService $dashboardService, array $config = [])
    {
        $this->modelService = $dashboardService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $this->modelService->index();

        return $this->extraRender('/lk/dashboard/index', [
            'data' => $this->modelService->getData(),
            'modelService' => $this->modelService
        ]);
    }
}
