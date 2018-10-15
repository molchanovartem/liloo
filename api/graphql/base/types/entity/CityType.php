<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;

/**
 * Class CityType
 *
 * @package api\graphql\base\types\entity
 */
class CityType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'country_id' => $this->typeRegistry->id(),
            'region_id' => $this->typeRegistry->id(),
            'district_id' => $this->typeRegistry->id(),
            'prefix' => $this->typeRegistry->string(),
            'name' => $this->typeRegistry->string(),
            'phone_code' => $this->typeRegistry->int(),
            'latitude' => $this->typeRegistry->decimal(),
            'longitude' => $this->typeRegistry->decimal()
        ];
    }
}