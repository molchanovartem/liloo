<?php

namespace app\modules\api\services\v1;

use app\core\models\Convenience;

/**
 * Class ConvenienceModelService
 * @package app\modules\api\services\v1
 */
class ConvenienceModelService extends ModelService
{
    public function getItem($arguments = [])
    {
        $query = Convenience::find()
            ->where(['id' => $arguments['id']]);

        if ($this->isDataTypeArray()) {
            $query->asArray();
        }

        $this->setData(['item' => $query->one()]);
    }

    public function getItems($arguments = [])
    {
        $query = Convenience::find();

        if ($this->isDataTypeArray()) {
            $query->asArray();
        }

        $this->setData(['items' => $query->all()]);
    }
}