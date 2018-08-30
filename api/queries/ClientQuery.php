<?php

namespace api\queries;

/**
 * Class ClientQuery
 *
 * @package api\queries
 */
class ClientQuery extends \common\queries\ClientQuery
{
    public function allByParams(int $limit, int $offset)
    {
        return $this->byAccountId()
            ->limit($limit)
            ->offset($offset)
            ->all();
    }
}