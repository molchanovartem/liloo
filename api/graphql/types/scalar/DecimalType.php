<?php

namespace api\graphql\types\scalar;

use yii\validators\NumberValidator;

/**
 * Class DecimalType
 *
 * @package api\graphql\types\scalar
 */
class DecimalType extends ValidationYiiType
{
    public $name = 'Decimal';

    protected $validatorClass = NumberValidator::class;
}