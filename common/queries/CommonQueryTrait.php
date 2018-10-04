<?php

namespace common\queries;

/**
 * Trait CommonQueryTrait
 *
 * @package common\queries
 */
trait CommonQueryTrait
{
    use CommonByQueryTrait;

    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id)
    {
        return $this->byId($id)
            ->one();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id)
    {
        return $this->byId($id)
            ->exists();
    }

    /**
     * @param int $countryId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByCountryId(int $countryId)
    {
        return $this->byCountryId($countryId)
            ->all();
    }

    public function allByCurrentAccountId()
    {
        return $this->byCurrentAccountId()
            ->all();
    }

    /**
     * @param array $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allById(array $id)
    {
        return $this->byId($id)
            ->all();
    }

    /**
     * @return int|string
     */
    public function countByCurrentAccountId()
    {
        return $this->byCurrentAccountId()
            ->count();
    }

    public function oneByCurrentUserId()
    {
        return $this->byCurrentUserId()
            ->one();
    }

    public function currentUser()
    {
        return $this->byIdCurrentUser()
            ->one();
    }
}