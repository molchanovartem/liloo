<?php

namespace api\queries;

use yii\db\ActiveQuery;
use api\queries\traits\AccountQueryTrait;
use api\queries\traits\UserByQueryTrait;

/**
 * Class UserQuery
 *
 * @package api\queries
 */
class UserQuery extends ActiveQuery
{
    use AccountQueryTrait;
    use UserByQueryTrait;

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function currentUser()
    {
        return $this->byIdCurrentUser()
            ->one();
    }
}
