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
        return $this->limit($limit)
            ->offset($offset)
            ->allByAccountId();
    }
}