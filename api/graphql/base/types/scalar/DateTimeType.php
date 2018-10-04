<?php

namespace api\graphql\base\types\scalar;

/**
 * Class DateTimeType
 *
 * @package api\graphql\base\types\scalar
 */
class DateTimeType extends DateType
{
    /**
     * @var string
     */
    public $name = 'DateTime';
    /**
     * @var array
     */
    protected $params = ['format' => 'php:Y-m-d H:i:s'];
}