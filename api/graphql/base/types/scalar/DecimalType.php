<?php

namespace api\graphql\base\types\scalar;

use yii\validators\NumberValidator;

/**
 * Class DecimalType
 *
 * @package api\graphql\base\types\scalar
 */
class DecimalType extends ValidationYiiType
{
    public $name = 'Decimal';

    protected $validatorClass = NumberValidator::class;
}