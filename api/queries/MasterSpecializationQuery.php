<?php

namespace api\queries;

use api\queries\traits\AccountQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class MasterSpecializationQuery
 *
 * @package api\queries
 */
class MasterSpecializationQuery extends ActiveQuery
{
    use AccountQueryTrait;

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
