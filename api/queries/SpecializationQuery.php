<?php

namespace api\queries;

/**
 * Class SpecializationQuery
 * @package api\queries
 */
class SpecializationQuery extends \common\queries\SpecializationQuery
{
    use AccountQueryTrait;

    /**
     * @param int $limit
     * @param int $offset
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams(int $limit, int $offset)
    {
        return $this->limit($limit)
            ->offset($offset)
            ->all();
    }
}
