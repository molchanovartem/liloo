<?php

namespace api\queries;

/**
 * Class UserQuery
 *
 * @package api\queries
 */
class UserQuery extends \common\queries\UserQuery
{
    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function currentUser()
    {
        return $this->byIdCurrentUser()
            ->one();
    }
}