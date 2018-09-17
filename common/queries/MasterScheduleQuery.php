<?php

namespace common\queries;

/**
 * Class MasterScheduleQuery
 *
 * @package common\queries
 */
class MasterScheduleQuery extends Query
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