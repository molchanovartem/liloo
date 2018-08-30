<?php

namespace api\modules\v1\controllers;

use api\modules\v1\services\PortfolioModelService;

/**
 * Class PortfolioController
 * @package api\modules\v1\controllers
 */
class PortfolioController extends Controller
{
    public function __construct(string $id, $module, PortfolioModelService $modelService, array $config = [])
    {
        $this->modelService = $modelService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        return [];
    }

    /**
     * @param null $salonId
     * @param null $serviceId
     * @return null
     */
    public function actionIndex($salonId = null, $serviceId = null)
    {
        $this->modelService->index($salonId, $serviceId);

        return $this->modelService->getResult();
    }
}