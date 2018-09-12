<?php

namespace common\queries;

/**
 * Class MasterServiceQuery
 *
 * @package common\queries
 */
class MasterServiceQuery extends AccountQuery
{
    /**
     * @param int $masterId
     * @param int $salonId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams(int $masterId, int $salonId)
    {
        return $this->byMasterId($masterId)
            ->bySalonId($salonId)
            ->allByAccountId();
    }
}