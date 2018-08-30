<?php

namespace common\queries;

/**
 * Class CityQuery
 *
 * @package common\queries
 */
class CityQuery extends Query
{
    public function byCountryId(int $countryId)
    {
        return $this->andWhere(['country_id' => $countryId]);
    }

    public function allByCountryId(int $countryId)
    {
        return $this->byCountryId($countryId)
            ->all();
    }
}