<?php

namespace common\queries;

use Yii;

/**
 * Class AccountQuery
 *
 * @package common\queries
 */
class AccountQuery extends Query
{
    /**
     * @param null $alias
     * @return Query
     */
    public function byAccountId($alias = null)
    {
        $attribute = $alias ? $alias . '.account_id' : 'account_id';

        return $this->andWhere([$attribute => Yii::$app->account->getId()]);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByAccountId()
    {
        return $this->byAccountId()
            ->all();
    }

    /**
     * @param int $salonId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allBySalonId(int $salonId)
    {
        return $this->byAccountId()
            ->bySalonId($salonId)
            ->all();
    }

    /**
     * @return int|string
     */
    public function countByAccountId()
    {
        return $this->byAccountId()
            ->count();
    }

    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id)
    {
        return $this->byAccountId()
            ->byId($id)
            ->one();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id)
    {
        return $this->byAccountId()
            ->byId($id)
            ->exists();
    }

}