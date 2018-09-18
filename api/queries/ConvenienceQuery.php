<?php

namespace api\queries;

use common\queries\CommonQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class ConvenienceQuery
 *
 * @package api\queries
 */
class ConvenienceQuery extends ActiveQuery
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
