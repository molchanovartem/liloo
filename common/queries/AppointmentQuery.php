<?php

namespace common\queries;

/**
 * Class AppointmentQuery
 *
 * @package common\queries
 */
class AppointmentQuery extends Query
{
    /**
     * @param int $id
     * @param bool $byAccountId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id, $byAccountId = true)
    {
        return parent::oneById($id, $byAccountId); // TODO: Change the autogenerated stub
    }
}