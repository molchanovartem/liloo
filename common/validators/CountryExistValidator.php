<?php

namespace common\validators;

use common\models\Country;

/**
 * Class CountryExistValidator
 *
 * @package common\validators
 */
class CountryExistValidator extends \yii\validators\ExistValidator
{
    public function init()
    {
        parent::init();

        $this->targetClass = Country::class;
        $this->targetAttribute = 'id';
    }
}