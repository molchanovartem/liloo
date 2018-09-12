<?php

namespace common\queries;

/**
 * Class ClientQuery
 *
 * @package common\queries
 */
class ClientQuery extends AccountQuery
{
    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id)
    {
        return parent::oneById($id);
    }
}