<?php

namespace api\graphql\core;

/**
 * Class Buffer
 *
 * @package api\graphql\core
 */
class Buffer
{
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