<?php

namespace api\queries;

/**
 * Class ConvenienceQuery
 * @package api\queries
 */
class ConvenienceQuery extends \common\queries\ConvenienceQuery
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
            ->all();
    }
}
