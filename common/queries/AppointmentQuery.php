<?php

namespace common\queries;

/**
 * Class AppointmentQuery
 *
 * @package common\queries
 */
class AppointmentQuery extends AccountQuery
{
    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id)
    {
        return parent::oneById($id);
    }
}