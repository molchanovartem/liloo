<?php

namespace api\buffers;

/**
 * Class ClientBuffer
 *
 * @package api\buffers
 */
class ClientBuffer extends Buffer
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