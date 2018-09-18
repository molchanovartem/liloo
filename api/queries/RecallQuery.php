<?php

namespace api\queries;

use api\queries\traits\AccountQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class RecallQuery
 *
 * @package api\queries
 */
class RecallQuery extends ActiveQuery
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
