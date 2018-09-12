<?php

namespace common\queries;

/**
 * Class MasterSpecializationQuery
 *
 * @package common\queries
 */
class MasterSpecializationQuery extends AccountQuery
{
    /**
     * @param int $masterId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByMasterId(int $masterId)
    {
        return $this->byMasterId($masterId)
            ->allByAccountId();
    }
}