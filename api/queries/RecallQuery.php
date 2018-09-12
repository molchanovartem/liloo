<?php

namespace api\queries;

class RecallQuery extends \common\queries\RecallQuery
{
    /**
     * @param $appointmentId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams($appointmentId)
    {
        return $this->byAppointmentId($appointmentId)
            ->allByAccountId();
    }
}