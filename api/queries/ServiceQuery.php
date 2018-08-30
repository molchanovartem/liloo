<?php

namespace api\queries;

/**
 * Class ServiceQuery
 *
 * @package api\queries
 */
class ServiceQuery extends \common\queries\ServiceQuery
{
    public function allByParams($parentId, int $limit, int $offset)
    {
        return $this->where(['parent_id' => $parentId])
            ->byAccountId()
            ->orderBy(['is_group' => SORT_DESC])
            ->limit($limit)
            ->offset($offset)
            ->all();
    }

    public function allServiceByParams($parentId, int $limit, int $offset)
    {
        return $this->where(['parent_id' => $parentId])
            ->isService()
            ->byAccountId()
            ->limit($limit)
            ->offset($offset)
            ->all();
    }
}