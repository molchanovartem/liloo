<?php

namespace api\queries;

use yii\db\ActiveQuery;
use api\queries\traits\AccountQueryTrait;

/**
 * Class MasterServiceQuery
 *
 * @package api\queries
 */
class MasterServiceQuery extends ActiveQuery
{
    use AccountQueryTrait;

    /**
     * @param int $masterId
     * @param int $salonId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams(int $masterId, int $salonId)
    {
        return $this->byMasterId($masterId)
            ->bySalonId($salonId)
            ->allByCurrentAccountId();
    }
}
