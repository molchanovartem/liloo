<?php

namespace api\graphql\lk\buffers;

use api\graphql\ActiveBuffer;

/**
 * Class ClientBuffer
 *
 * @package api\graphql\lk\buffers
 */
class ClientBuffer extends ActiveBuffer
{
    public function oneById(int $id)
    {
        if (!$this->data) {
            $this->data = $this->where(['in', 'id', $this->getKeys()])
                ->indexBy('id')
                ->allByCurrentAccountId();
        }
        return $this->data[$id] ?? null;
    }
}