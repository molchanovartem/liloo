<?php

namespace api\schema\type\scalar;

use yii\validators\NumberValidator;

/**
 * Class DecimalType
 *
 * @package api\schema\type\scalar
 */
class DecimalType extends ValidationYiiType
{
    public $name = 'Decimal';

    protected $validatorClass = NumberValidator::class;
}