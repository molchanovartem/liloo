<?php

namespace site\services\lk;

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
}
