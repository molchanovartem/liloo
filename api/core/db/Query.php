<?php

namespace api\core\db;

/**
 * Class Query
 * @package api\core\db
 */
class Query extends \yii\db\Query
{
    public function isAccount($alias = null)
    {
        $attribute = $alias ? $alias . '.account_id' : 'account_id';

        //return $this->andWhere([$attribute => Yii::$app->account->getId()]);
        return $this->andWhere([$attribute => 1]);
    }
}