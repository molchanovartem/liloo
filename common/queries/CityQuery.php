<?php

namespace common\queries;

/**
 * Class CityQuery
 *
 * @package common\queries
 */
class CityQuery extends Query
{
    /**
     * @param int $countryId
     * @return CityQuery
     */
    public function byCountryId(int $countryId)
    {
        return $this->andWhere(['country_id' => $countryId]);
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
}