<?php

namespace api\queries\traits;

use common\queries\CommonByQueryTrait;

/**
 * Trait AccountQuery
 *
 * @package api\queries
 */
trait AccountQueryTrait
{
    use AccountByQueryTrait;
    use CommonByQueryTrait;

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByCurrentAccountId()
    {
        return $this->byCurrentAccountId()
            ->all();
    }

    /**
     * @param int $salonId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allBySalonId(int $salonId)
    {
        return $this->byCurrentAccountId()
            ->bySalonId($salonId)
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

    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneById(int $id)
    {
        return $this->byCurrentAccountId()
            ->byId($id)
            ->one();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id)
    {
        return $this->byCurrentAccountId()
            ->byId($id)
            ->exists();
    }

}
