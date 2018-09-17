<?php

namespace common\queries;

/**
 * Class SalonMasterQuery
 *
 * @package common\queries
 */
class SalonMasterQuery extends Query
{
    /**
     * @param int $salonId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allBySalonId(int $salonId)
    {
        return $this->bySalonId($salonId)
            ->allByCurrentAccountId();
    }
}