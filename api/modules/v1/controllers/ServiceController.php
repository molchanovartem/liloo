<?php

namespace api\modules\v1\controllers;

use api\modules\v1\services\ServiceModelService;

/**
 * Class ServiceController
 * @package api\modules\v1\controllers
 */
class ServiceController extends Controller
{
    public function __construct(string $id, $module, ServiceModelService $modelService, array $config = [])
    {
        $this->modelService = $modelService;

        parent::__construct($id, $module, $config);
    }
}