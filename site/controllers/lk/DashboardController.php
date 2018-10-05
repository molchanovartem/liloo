<?php

namespace site\controllers\lk;

use site\services\SiteService;

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
    public function actionView()
    {
        $this->modelService->index();
        $data = $this->modelService->getData();

        return $this->extraRender('/lk/dashboard/view', [
            'specializations' => $data['specializations'],
            'modelService' => $this->modelService
        ]);
    }
}