<?php

namespace common\queries;

/**
 * Class ServiceQuery
 *
 * @package common\queries
 */
class ServiceQuery extends Query
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

    /**
     * @param int $id
     * @return mixed
     */
    public function oneServiceById(int $id)
    {
        return $this->byId($id)
            ->isService()
            ->oneById($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function oneGroupById(int $id)
    {
        return $this->byId($id)
            ->isGroup()
            ->oneById($id);
    }

    /**
     * @param null $parentId
     * @return mixed
     */
    public function allByParentId($parentId = null)
    {
        return $this->byParentId($parentId)
            ->isService()
            ->allByCurrentAccountId();
    }

    /**
     * @param null $parentId
     * @return mixed
     */
    public function allGroupByParentId($parentId = null)
    {
        return $this->byParentId($parentId)
            ->isGroup()
            ->allByCurrentAccountId();
    }

    /**
     * @return ServiceQuery
     */
    public function isGroup()
    {
        return $this->andWhere(['is_group' => (int)true]);
    }

    /**
     * @return ServiceQuery
     */
    public function isService()
    {
        return $this->andWhere(['is_group' => (int)false]);
    }
}