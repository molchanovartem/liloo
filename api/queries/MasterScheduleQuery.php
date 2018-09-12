<?php

namespace api\queries;

/**
 * Class MasterScheduleQuery
 *
 * @package api\queries
 */
class MasterScheduleQuery extends \common\queries\MasterScheduleQuery
{
    public function allByParams($startDate, $endDate, $salonId = null, $masterId = null)
    {
        return $this->where(['between', 'start_date', $startDate, $endDate])
            ->andFilterWhere(['salon_id' => $salonId, 'master_id' => $masterId])
            ->allByAccountId();
    }
}