<?php

namespace api\queries;

/**
 * Class ConvenienceQuery
 * @package api\queries
 */
class ConvenienceQuery extends \common\queries\ConvenienceQuery
{
    public function allByParams(int $limit, int $offset)
    {
        return $this->limit($limit)
            ->offset($offset)
            ->all();
    }
}