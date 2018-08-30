<?php

namespace api\buffers;

use yii\base\UnknownMethodException;
use yii\db\ActiveQuery;

/**
 * Class Buffer
 *
 * @package api\buffers
 */
class Buffer
{
    protected $activeQuery;

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

    /**
     * @var array
     */
    protected $keys = [];
    /**
     * @var null
     */
    protected $data = null;

    /**
     * @param $key
     */
    public function addKey($key)
    {
        $this->keys[] = $key;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }
}