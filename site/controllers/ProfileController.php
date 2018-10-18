<?php

namespace site\controllers;

use site\services\ProfileService;
use yii\filters\AccessControl;

/**
 * Class ProfileController
 * @package site\controllers
 */
class ProfileController extends Controller
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
     * ProfileController constructor.
     *
     * @param string           $id
     * @param \yii\base\Module $module
     * @param ProfileService   $profileService
     * @param array            $config
     */
    public function __construct(string $id, $module, ProfileService $profileService, array $config = [])
    {
        $this->modelService = $profileService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return array|string
     * @throws \Exception
     */
    public function actionView()
    {
        $this->modelService->findUser();

        return $this->extraRender('/profile/view', ['data' => $this->modelService->getData()]);
    }

    /**
     * @return array|string
     */
    public function actionUpdate()
    {
        $this->modelService->update();

        return $this->extraRender('/profile/update', ['data' => $this->modelService->getData()]);
    }
}
