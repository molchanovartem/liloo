<?php

namespace api\queries;

use yii\db\ActiveQuery;
use api\queries\traits\AccountQueryTrait;

/**
 * Class MasterScheduleQuery
 *
 * @package api\queries
 */
class MasterScheduleQuery extends ActiveQuery
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
