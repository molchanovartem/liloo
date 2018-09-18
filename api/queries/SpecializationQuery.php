<?php

namespace api\queries;

use yii\db\ActiveQuery;
use common\queries\CommonQueryTrait;

/**
 * Class SpecializationQuery
 *
 * @package api\queries
 */
class SpecializationQuery extends ActiveQuery
{
    use CommonQueryTrait;

    /**
     * @param int $limit
     * @param int $offset
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams(int $limit, int $offset)
    {
        return $this->limit($limit)
            ->offset($offset)
            ->all();
    }
}
