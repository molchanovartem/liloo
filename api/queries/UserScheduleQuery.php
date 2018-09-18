<?php

namespace api\queries;

use api\queries\traits\AccountQueryTrait;
use api\queries\traits\UserByQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class UserScheduleQuery
 *
 * @package api\queries
 */
class UserScheduleQuery extends ActiveQuery
{
    use AccountQueryTrait;
    use UserByQueryTrait;

    /**
     * @param $startDate
     * @param $endDate
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams($startDate, $endDate)
    {
        return $this->where(['between', 'start_date', $startDate, $endDate])
            ->byCurrentUserId()
            ->all();
    }

    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id)
    {
        return $this->byId($id)
            ->byCurrentUserId()
            ->one();
    }
}
