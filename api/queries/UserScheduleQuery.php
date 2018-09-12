<?php

namespace api\queries;

/**
 * Class UserScheduleQuery
 *
 * @package api\queries
 */
class UserScheduleQuery extends \common\queries\UserScheduleQuery
{
    public function allByParams($startDate, $endDate)
    {
        return $this->where(['between', 'start_date', $startDate, $endDate])
            ->byUserIdCurrentUser()
            ->all();
    }
}