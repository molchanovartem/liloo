<?php

namespace api\schema\type\scalar;

/**
 * Class DateTimeType
 *
 * @package api\schema\type\scalar
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