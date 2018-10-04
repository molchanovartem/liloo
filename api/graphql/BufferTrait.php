<?php

namespace api\graphql;

/**
 * Trait BufferTrait
 *
 * @package api\graphql
 */
trait BufferTrait
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