<?php

namespace api\buffers;

use api\queries\ServiceQuery;

/**
 * Class ServiceBuffer
 *
 * @package api\buffers
 */
class ServiceBuffer extends ServiceQuery
{
    use BufferTrait;

    /**
     * @param int $id
     * @return null|\yii\db\ActiveRecord
     */
    public function oneServiceById(int $id)
    {
        if (!$this->data) {
            $this->data = $this->where(['in', 'id', $this->getKeys()])
                ->isService()
                ->indexBy('id')
                ->allByCurrentAccountId();
        }
        return $this->data[$id] ?? null;
    }
}