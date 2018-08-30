<?php

namespace common\validators;

use common\models\Master;

/**
 * Class MasterExistValidator
 *
 * @package common\validators
 */
class MasterExistValidator extends \yii\validators\ExistValidator
{
    public function init()
    {
        parent::init();

        $this->targetClass = Master::class;
        $this->targetAttribute = 'id';
        $this->filter = function ($query) {
            return $query->byAccountId();
        };
    }
}