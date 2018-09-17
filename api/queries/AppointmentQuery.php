<?php

namespace api\queries;

/**
 * Class AppointmentQuery
 *
 * @package api\queries
 */
class AppointmentQuery extends \common\queries\AppointmentQuery
{
    use AccountQueryTrait;
    /**
     * @param $startDate
     * @param $endDate
     * @param null $userId
     * @param null $salonId
     * @param null $masterId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams($startDate, $endDate, $userId = null, $salonId = null, $masterId = null)
    {
        return $this->where(['between', 'start_date', $startDate, $endDate])
            ->andFilterWhere(['user_id' => $userId])
            ->andFilterWhere(['salon_id' => $salonId])
            ->andFilterWhere(['master_id' => $masterId])
            ->allByCurrentAccountId();
    }
}
