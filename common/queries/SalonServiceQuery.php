<?php

namespace common\queries;

/**
 * Class SalonServiceQuery
 *
 * @package common\queries
 */
class SalonServiceQuery extends AccountQuery
{
    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id)
    {
        return parent::oneById($id);
    }

    /**
     * @param array $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allById(array $id)
    {
        return $this->byId($id)
            ->indexBy('id')
            ->allByAccountId();
    }
}