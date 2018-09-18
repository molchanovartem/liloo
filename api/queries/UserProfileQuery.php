<?php

namespace api\queries;

use yii\db\ActiveQuery;
use api\queries\traits\AccountQueryTrait;
use api\queries\traits\UserByQueryTrait;

/**
 * Class UserProfileQuery
 *
 * @package api\queries
 */
class UserProfileQuery extends ActiveQuery
{
    use AccountQueryTrait;
    use UserByQueryTrait;

    public function oneByCurrentUserId()
    {
        return $this->byCurrentUserId()
            ->one();
    }
}
