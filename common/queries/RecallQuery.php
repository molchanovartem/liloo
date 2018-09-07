<?php

namespace common\queries;

/**
 * Class RecallQuery
 * @package common\queries
 */
class RecallQuery extends Query
{
    /**
     * @param int $id
     * @param bool $byAccountId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id, $byAccountId = true)
    {
        return parent::oneById($id, $byAccountId);
    }

    /**
     * @param $appointmentId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams($appointmentId)
    {
        return $this->byAppointmentId($appointmentId)
            ->byAccountId()
            ->all();
    }
}
