<?php

namespace api\queries;

use Yii;

/**
 * Trait AccountQuery
 * @package api\queries
 */
trait AccountQueryTrait
{
    /**
     * @param null $alias
     * @return mixed
     */
    public function byAccountId($alias = null)
    {
        $attribute = $alias ? $alias . '.account_id' : 'account_id';

        return $this->andWhere([$attribute => Yii::$app->account->getId()]);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByCurrentAccountId()
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
