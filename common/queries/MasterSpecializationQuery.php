<?php

namespace common\queries;

/**
 * Class MasterSpecializationQuery
 *
 * @package common\queries
 */
class MasterSpecializationQuery extends Query
{
    /**
     * @param int $masterId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByMasterId(int $masterId)
    {
        return $this->byMasterId($masterId)
            ->allByCurrentAccountId();
    }
}