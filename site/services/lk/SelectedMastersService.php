<?php

namespace site\services\lk;

use Yii;
use common\core\service\ModelService;
use common\models\SelectedMasters;

/**
 * Class SelectedMastersService
 * @package site\services\lk
 */
class SelectedMastersService extends ModelService
{
    public function index()
    {
        $this->findSelectedMasters();
        $model = $this->getData('selectedMasters');

        $this->setData(['model' => $model]);
    }

    public function findSelectedMasters()
    {
        $this->setData([
            'selectedMasters' => SelectedMasters::find()
                ->byCurrentUserId()
                ->all(),
        ]);
    }

    /**
     * @param $executorId
     * @param $isSalon
     */
    public function addToSelected($executorId, $isSalon)
    {
        $selectedMaster = SelectedMasters::find()
                ->where(['executor_id' => $executorId])
                ->andWhere(['is_salon' => $isSalon])
                ->byCurrentUserId()
                ->one();
        if (empty($selectedMaster)) {
            $selectedMaster = new SelectedMasters();

            $selectedMaster->user_id = Yii::$app->user->getId();
            $selectedMaster->executor_id = $executorId;
            $selectedMaster->is_salon = $isSalon;

            $selectedMaster->save();
        } else {
            $selectedMaster->delete();
        }
    }
}
