<?php

namespace common\queries;

/**
 * Class UserScheduleQuery
 *
 * @package common\queries
 */
class UserScheduleQuery extends Query
{
    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id)
    {
        return $this->byId($id)
            ->byUserIdCurrentUser()
            ->one();
    }
}