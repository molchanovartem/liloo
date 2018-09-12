<?php

namespace common\queries;

/**
 * Class AppointmentItemQuery
 *
 * @package common\queries
 */
class AppointmentItemQuery extends \common\queries\AccountQuery
{
    /**
     * @param array $id
     * @return mixed
     */
    public function allById(array $id)
    {
        return $this->byId($id)
            ->allByAccountId();
    }

    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id)
    {
        return parent::oneById($id);
    }
}