<?php

namespace api\graphql\core;

use yii\base\UnknownMethodException;
use yii\db\ActiveQuery;

/**
 * Class ActiveBuffer
 *
 * @package api\graphql\core
 */
class ActiveBuffer extends Buffer
{
    /**
     * @var ActiveQuery
     */
    protected $activeQuery;

    /**
     * ActiveBuffer constructor.
     *
     * @param ActiveQuery $activeQuery
     */
    public function __construct(ActiveQuery $activeQuery)
    {
        $this->activeQuery = $activeQuery;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->activeQuery, $name)) {
            return call_user_func_array([$this->activeQuery, $name], $arguments);
        }

        throw new UnknownMethodException('Calling unknown method: ' . get_class($this) . "::$name()");
    }
}