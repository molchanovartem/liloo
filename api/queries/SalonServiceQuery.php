<?php

namespace api\queries;

use yii\db\ActiveQuery;
use api\queries\traits\AccountQueryTrait;

/**
 * Class SalonServiceQuery
 *
 * @package api\queries
 */
class SalonServiceQuery extends ActiveQuery
{
    use AccountQueryTrait;

    /**
     * @param array $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allById(array $id)
    {
        return $this->byId($id)
            ->indexBy('id')
            ->allByCurrentAccountId();
    }
}
