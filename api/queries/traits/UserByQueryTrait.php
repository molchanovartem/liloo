<?php

namespace api\queries\traits;

use Yii;

/**
 * Trait UserQueryTrait
 *
 * @package api\queries\traits
 */
trait UserByQueryTrait
{
    public function byCurrentUserId()
    {
        return $this->andWhere(['user_id' => Yii::$app->user->getId()]);
    }

    public function byIdCurrentUser()
    {
        return $this->andWhere(['id' => Yii::$app->user->getId()]);
    }
}