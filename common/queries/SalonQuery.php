<?php

namespace common\queries;

/**
 * Class SalonQuery
 *
 * @package common\queries
 */
class SalonQuery extends AccountQuery
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
     * @param int $limit
     * @param int $offset
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams(int $limit, int $offset)
    {
        return $this->byAccountId()
            ->limit($limit)
            ->offset($offset)
            ->all();
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