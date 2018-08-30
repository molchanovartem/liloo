<?php

namespace common\validators;

use common\models\Salon;

/**
 * Class SalonExistValidator
 *
 * @package common\validators
 */
class SalonExistValidator extends \yii\validators\ExistValidator
{
    public function init()
    {
        parent::init();

        $this->targetClass = Salon::class;
        $this->targetAttribute = 'id';
        $this->filter = function ($query) {
            return $query->byAccountId();
        };
    }
}