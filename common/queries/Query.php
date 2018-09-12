<?php

namespace common\queries;

use Yii;

/**
 * Class Query
 *
 * @package common\queries
 */
class Query extends \yii\db\ActiveQuery
{
    /**
     * @param $id
     * @return Query
     */
    public function byId($id)
    {
        if (is_array($id)) {
            return $this->andWhere(['in', 'id', $id]);
        }
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param int $appointmentId
     * @return Query
     */
    public function byAppointmentId(int $appointmentId)
    {
        return $this->andWhere(['appointment_id' => $appointmentId]);
    }

    /**
     * @param null $parentId
     * @return Query
     */
    public function byParentId($parentId = null)
    {
        return $this->andWhere(['parent_id' => $parentId]);
    }

    /**
     * @return Query
     */
    public function byIdCurrentUser()
    {
        return $this->byId($this->getUserId());
    }

    /**
     * @return Query
     */
    public function byUserIdCurrentUser()
    {
        return $this->byUserId($this->getUserId());
    }

    /**
     * @param int $userId
     * @return Query
     */
    public function byUserId(int $userId)
    {
        return $this->andWhere(['user_id' => $userId]);
    }

    /**
     * @param int $masterId
     * @return Query
     */
    public function byMasterId(int $masterId)
    {
        return $this->andWhere(['master_id' => $masterId]);
    }

    /**
     * @param int $salonId
     * @return Query
     */
    public function bySalonId(int $salonId)
    {
        return $this->andWhere(['salon_id' => $salonId]);
    }

    /**
     * @param int $salonId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allBySalonId(int $salonId)
    {
        return $this->bySalonId($salonId)
            ->all();
    }

    /*
    public function oneByUserId(int $userId)
    {
        return $this->byUserId($userId)
            ->one();
    }
    */

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function oneByUserIdCurrentUser()
    {
        return $this->byUserIdCurrentUser()
            ->one();
    }

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
     * @return int
     */
    protected function getUserId()
    {
        return Yii::$app->user->getId();
    }
}
