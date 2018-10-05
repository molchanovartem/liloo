<?php

namespace site\controllers\lk;

use site\services\lk\ProfileService;

/**
 * Class ProfileController
 *
 * @package site\services\lk
 */
class ProfileController extends Controller
{
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
     * @param $id
     * @return array|string
     * @throws \Exception
     */
    public function actionView($id)
    {
        $this->modelService->findUser($id);

        return $this->extraRender('/lk/profile/view', ['data' => $this->modelService->getData()]);
    }

    /**
     * @param $id
     * @return array|string
     */
    public function actionUpdate($id)
    {
        $this->modelService->update($id);

        return $this->extraRender('/lk/profile/update', ['data' => $this->modelService->getData()]);
    }
}
