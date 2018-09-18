<?php

namespace api\queries;

use yii\db\ActiveQuery;
use api\queries\traits\AccountQueryTrait;

/**
 * Class ClientQuery
 *
 * @package api\queries
 */
class ClientQuery extends ActiveQuery
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
