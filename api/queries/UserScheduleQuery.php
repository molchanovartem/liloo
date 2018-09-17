<?php

namespace api\queries;

/**
 * Class UserScheduleQuery
 *
 * @package api\queries
 */
class UserScheduleQuery extends \common\queries\UserScheduleQuery
{
    use AccountQueryTrait;

    /**
     * @param $startDate
     * @param $endDate
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams($startDate, $endDate)
    {
        return $this->where(['between', 'start_date', $startDate, $endDate])
            ->byUserIdCurrentUser()
            ->all();
    }
}
