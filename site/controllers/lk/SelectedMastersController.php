<?php

namespace site\controllers\lk;

use common\models\SelectedMasters;
use site\services\lk\SelectedMastersService;
use Yii;

class SelectedMastersController extends Controller
{
    /**
     * SelectedMastersController constructor.
     * @param string $id
     * @param $module
     * @param SelectedMastersService $selectedMastersService
     * @param array $config
     */
    public function __construct(string $id, $module, SelectedMastersService $selectedMastersService, array $config = [])
    {
        $this->modelService = $selectedMastersService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return array|string
     */
    public function actionIndex()
    {
        $this->modelService->index();

        return $this->extraRender('/lk/selectedMasters/index', ['data' => $this->modelService->getData()]);
    }

    /**
     * @param $executorId
     * @param $isSalon
     * @return bool
     */
    public function actionAddToSelected($executorId, $isSalon)
    {
        $selectedMaster = SelectedMasters::find()
            ->where(['executor_id' => $executorId])
            ->andWhere(['isSalon' => $isSalon])
            ->byCurrentUserId()
            ->one();

        if (empty($selectedMaster)) {
            $selectedMaster = new SelectedMasters();

            $selectedMaster->user_id = Yii::$app->user->getId();
            $selectedMaster->executor_id = $executorId;
            $selectedMaster->isSalon = $isSalon;

            return $selectedMaster->save();
        }

        return $selectedMaster->delete();
    }
}
