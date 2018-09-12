<?php

namespace common\queries;

/**
 * Class ServiceQuery
 *
 * @package common\queries
 */
class ServiceQuery extends AccountQuery
{
    /**
     * @param array $id
     * @return mixed
     */
    public function allByIdInService(array $id)
    {
        return $this->byId($id)
            ->isService()
            ->all();
    }


    public function oneServiceById(int $id)
    {
        return $this->byId($id)
            ->isService()
            ->oneById($id);
    }

    public function oneGroupById(int $id)
    {
        return $this->byId($id)
            ->isGroup()
            ->oneById($id);
    }

    public function allByParentId($parentId = null)
    {
        return $this->byParentId($parentId)
            ->isService()
            ->allByAccountId();
    }

    public function allGroupByParentId($parentId = null)
    {
        return $this->byParentId($parentId)
            ->isGroup()
            ->allByAccountId();
    }

    public function isGroup()
    {
        return $this->andWhere(['is_group' => (int) true]);
    }

    public function isService()
    {
        return $this->andWhere(['is_group' => (int) false]);
    }
}