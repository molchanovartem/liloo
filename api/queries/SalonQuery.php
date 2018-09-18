<?php

namespace api\queries;

use api\queries\traits\AccountQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class SalonQuery
 *
 * @package api\queries
 */
class SalonQuery extends ActiveQuery
{
    use AccountQueryTrait;

    /**
     * @param int $limit
     * @param int $offset
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams(int $limit, int $offset)
    {
        return $this->limit($limit)
            ->offset($offset)
            ->allByCurrentAccountId();
    }
}
