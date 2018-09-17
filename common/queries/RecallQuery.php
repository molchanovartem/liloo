<?php

namespace common\queries;

/**
 * Class RecallQuery
 * @package common\queries
 */
class RecallQuery extends Query
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
