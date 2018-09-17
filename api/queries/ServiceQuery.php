<?php

namespace api\queries;

/**
 * Class ServiceQuery
 *
 * @package api\queries
 */
class ServiceQuery extends \common\queries\ServiceQuery
{
    use AccountQueryTrait;

    /**
     * @param $parentId
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function allByParams($parentId, int $limit, int $offset)
    {
        return $this->where(['parent_id' => $parentId])
            ->orderBy(['is_group' => SORT_DESC])
            ->limit($limit)
            ->offset($offset)
            ->allByCurrentAccountId();
    }

    /**
     * @param $parentId
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function allServiceByParams($parentId, int $limit, int $offset)
    {
        return $this->where(['parent_id' => $parentId])
            ->isService()
            ->limit($limit)
            ->offset($offset)
            ->allByCurrentAccountId();
    }
}
