<?php

namespace api\modules\v1\queries;

use Yii;
use yii\db\ActiveQuery;

/**
 * Class Query
 * @package api\modules\v1\queries
 */
abstract class Query extends ActiveQuery
{
    public function isAccount($alias = null)
    {
        $attribute = $alias ? $alias . '.account_id' : 'account_id';

        //return $this->andWhere([$attribute => Yii::$app->account->getId()]);
        return $this->andWhere([$attribute => 1]);
    }
}