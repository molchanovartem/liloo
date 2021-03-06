<?php

namespace api\graphql\base\types\scalar;

use yii\validators\DateValidator;

/**
 * Class DateType
 *
 * @package api\graphql\base\types\scalar
 */
class DateType extends ValidationYiiType
{
    /**
     * @var string
     */
    public $name = 'Date';
    /**
     * @var string
     */
    protected $validatorClass = DateValidator::class;
    /**
     * @var array
     */
    protected $params = ['format' => 'php:Y-m-d'];
}