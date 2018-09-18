<?php

namespace api\queries\traits;

use Yii;

/**
 * Trait AccountQuery
 * @package api\queries
 */
trait AccountByQueryTrait
{
    public function byCurrentAccountId($alias = null)
    {
        return $this->byAccountId(Yii::$app->account->getId(), $alias);
    }
}
