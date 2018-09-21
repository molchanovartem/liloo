<?php

namespace common\queries;

/**
 * Trait CommonQueryTrait
 *
 * @package common\queries
 */
trait CommonByQueryTrait
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

    public function byAccountId(int $accountId, $alias = null)
    {
        $attribute = $alias ? $alias . '.account_id' : 'account_id';

        return $this->andWhere([$attribute => $accountId]);
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
     * @param int $countryId
     * @return CityQuery
     */
    public function byCountryId(int $countryId)
    {
        return $this->andWhere(['country_id' => $countryId]);
    }

    /**
     * @param int $tariffId
     * @return mixed
     */
    public function byTariffId(int $tariffId)
    {
        return $this->andWhere(['tariff_id' => $tariffId]);
    }

    /**
     * @param int $priceId
     * @return mixed
     */
    public function byPriceId(int $priceId)
    {
        return $this->andWhere(['price_id' => $priceId]);
    }
}