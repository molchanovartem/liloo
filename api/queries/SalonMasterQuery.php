<?php

namespace api\queries;

use yii\db\ActiveQuery;
use api\queries\traits\AccountQueryTrait;

/**
 * Class SalonMasterQuery
 *
 * @package api\queries
 */
class SalonMasterQuery extends ActiveQuery
{
    use AccountQueryTrait;

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
