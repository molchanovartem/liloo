<?php

namespace api\queries;

/**
 * Class ClientQuery
 *
 * @package api\queries
 */
class ClientQuery extends \common\queries\ClientQuery
{
    use AccountQueryTrait;

    /**
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function allByParams(int $limit, int $offset)
    {
        return $this->limit($limit)
            ->offset($offset)
            ->allByCurrentAccountId();
    }
}
