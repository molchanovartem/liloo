<?php

namespace api\queries;

/**
 * Class UserQuery
 * @package api\queries
 */
class UserQuery extends \common\queries\UserQuery
{
    use AccountQueryTrait;

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function currentUser()
    {
        return $this->byIdCurrentUser()
            ->one();
    }
}
