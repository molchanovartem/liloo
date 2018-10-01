<?php

namespace site\controllers;

use site\services\SiteService;

/**
 * Class SiteController
 *
 * @package site\controllers
 */
class SiteController extends Controller
{
    /**
     * SiteController constructor.
     * @param string $id
     * @param $module
     * @param SiteService $siteService
     * @param array $config
     */
    public function __construct(string $id, $module, SiteService $siteService, array $config = [])
    {
        $this->modelService = $siteService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $this->modelService->index();
        $data = $this->modelService->getData();

        return $this->extraRender('index', [
            'specializations' => $data['specializations'],
            'modelService' => $this->modelService
        ]);
    }
}
