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