<?php

namespace api\graphql\common\registry;

use api\graphql\AdditionalTypeRegistry;
use api\graphql\common\types\entity\CityType;
use api\graphql\common\types\entity\ConvenienceType;
use api\graphql\common\types\entity\CountryType;
use api\graphql\common\types\entity\CommonServiceType;
use api\graphql\common\types\entity\SpecializationType;
use api\graphql\common\types\entity\TariffType;
use api\graphql\common\types\entity\TariffPriceType;

/**
 * Class EntityTypeRegistry
 *
 * @package api\graphql\common\registry
 */
class EntityTypeRegistry extends AdditionalTypeRegistry
{
    public function country()
    {
        return $this->typeRegistry->get(CountryType::class);
    }

    public function city()
    {
        return $this->typeRegistry->get(CityType::class);
    }

    public function specialization()
    {
        return $this->typeRegistry->get(SpecializationType::class);
    }

    public function convenience()
    {
        return $this->typeRegistry->get(ConvenienceType::class);
    }

    public function service()
    {
        return $this->typeRegistry->get(CommonServiceType::class);
    }

    public function tariff()
    {
        return $this->typeRegistry->get(TariffType::class);
    }

    public function tariffPrice()
    {
        return $this->typeRegistry->get(TariffPriceType::class);
    }
}