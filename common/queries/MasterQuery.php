<?php

namespace common\queries;

/**
 * Class MasterQuery
 *
 * @package common\queries
 */
class MasterQuery extends AccountQuery
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
     * @param int $id
     * @return bool
     */
    public function existsById(int $id)
    {
        return parent::existsById($id);
    }
}