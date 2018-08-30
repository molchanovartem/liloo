<?php

namespace common\validators;

use common\models\City;

/**
 * Class CityExistValidator
 *
 * @package common\validators
 */
class CityExistValidator extends \yii\validators\ExistValidator
{
    public function init()
    {
        parent::init();

        $this->targetClass = City::class;
        $this->targetAttribute = 'id';
    }
}