<?php

namespace api\queries;

/**
 * Class MasterScheduleQuery
 *
 * @package api\queries
 */
class MasterScheduleQuery extends \common\queries\MasterScheduleQuery
{
    use AccountQueryTrait;

    /**
     * @param $startDate
     * @param $endDate
     * @param null $salonId
     * @param null $masterId
     * @return mixed
     */
    public function allByParams($startDate, $endDate, $salonId = null, $masterId = null)
    {
        return $this->where(['between', 'start_date', $startDate, $endDate])
            ->andFilterWhere(['salon_id' => $salonId, 'master_id' => $masterId])
            ->allByCurrentAccountId();
    }
}
