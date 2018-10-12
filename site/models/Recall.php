<?php

namespace site\models;

class Recall extends \common\models\Recall
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['status', 'default', 'value' => self::STATUS_NOT_VERIFIED],
        ]);
    }
}