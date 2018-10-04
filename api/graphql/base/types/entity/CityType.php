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
            'name' => $this->typeRegistry->string(),
            'phone_code' => $this->typeRegistry->string(),
            'latitude' => $this->typeRegistry->decimal(),
            'longitude' => $this->typeRegistry->decimal()
        ];
    }
}