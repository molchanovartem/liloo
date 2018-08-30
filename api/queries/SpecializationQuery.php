<?php

namespace api\queries;

/**
 * Class SpecializationQuery
 * @package api\queries
 */
class SpecializationQuery extends \common\queries\SpecializationQuery
{
    public function allByParams(int $limit, int $offset)
    {
        return $this->limit($limit)
            ->offset($offset)
            ->all();
    }
}