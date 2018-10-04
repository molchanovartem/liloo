<?php

namespace site\controllers;

use site\services\UserService;

class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param string $id
     * @param $module
     * @param UserService $userService
     * @param array $config
     */
    public function __construct(string $id, $module, UserService $userService, array $config = [])
    {
        $this->modelService = $userService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionView($id)
    {
        $this->modelService->findUser($id);

        return $this->extraRender('view', ['data' => $this->modelService->getData()]);
    }
}
