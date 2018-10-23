<?php

namespace api\graphql\base\types\entity;

use api\graphql\core\EntityType;

/**
 * Class UserProfileType
 *
 * @package api\graphql\base\types\entity
 */
class UserProfileType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'user_id' => $this->typeRegistry->id(),
            'country_id' => $this->typeRegistry->id(),
            'city_id' => $this->typeRegistry->id(),
            'surname' => $this->typeRegistry->string(),
            'name' => $this->typeRegistry->string(),
            'patronymic' => $this->typeRegistry->string(),
            'date_birth' => $this->typeRegistry->date(),
            'avatar' => $this->typeRegistry->string(),
            'description' => $this->typeRegistry->string(),
            'address' => $this->typeRegistry->string(),
            'phone' => $this->typeRegistry->string(),
            'latitude' => $this->typeRegistry->decimal(),
            'longitude' => $this->typeRegistry->decimal()
        ];
    }
}