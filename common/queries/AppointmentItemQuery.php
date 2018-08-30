<?php

namespace common\queries;

/**
 * Class AppointmentItemQuery
 *
 * @package common\queries
 */
class AppointmentItemQuery extends \common\queries\Query
{
    /**
     * @param array $id
     * @return mixed
     */
    public function allById(array $id)
    {
        return $this->byId($id)
            ->byAccountId()
            ->all();
    }

    /**
     * @param int $id
     * @param bool $byAccountId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id, $byAccountId = true)
    {
        return parent::oneById($id, $byAccountId);
    }
}