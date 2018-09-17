<?php

namespace api\queries;

class RecallQuery extends \common\queries\RecallQuery
{
    use AccountQueryTrait;

    /**
     * @param $appointmentId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams($appointmentId)
    {
        return $this->byAppointmentId($appointmentId)
            ->allByCurrentAccountId();
    }
}
