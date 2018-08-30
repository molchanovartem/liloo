<?php

namespace api\queries;

/**
 * Class UserScheduleQuery
 *
 * @package api\queries
 */
class UserScheduleQuery extends \common\queries\UserScheduleQuery
{
    public function allByParams($userId, $startDate, $endDate)
    {
        return $this->where(['between', 'start_date', $startDate, $endDate])
            ->andWhere(['user_id' => $userId])
            ->all();
    }
}