<?php

namespace api\modules\v1\controllers;

use api\modules\v1\services\ClientModelService;

/**
 * Class ClientController
 * @package api\controllers\v1
 */
class ClientController extends Controller
{
    public function __construct(string $id, $module, ClientModelService $modelService, array $config = [])
    {
        $this->modelService = $modelService;

        parent::__construct($id, $module, $config);
    }
}