<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;

/**
 * Class ClientType
 *
 * @package api\graphql\base\types\entity
 */
class ClientType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'user_id' => $this->typeRegistry->id(),
            'country_id' => $this->typeRegistry->id(),
            'city_id' => $this->typeRegistry->id(),
            'status' => $this->typeRegistry->int(),
            'surname' => $this->typeRegistry->string(),
            'name' => $this->typeRegistry->string(),
            'patronymic' => $this->typeRegistry->string(),
            'date_birth' => $this->typeRegistry->date(),
            'phone' => $this->typeRegistry->string(),
            'address' => $this->typeRegistry->string(),
            'total_appointment' => $this->typeRegistry->int(),
            'total_failure_appointment' => $this->typeRegistry->int(),
            'total_spent_money' => $this->typeRegistry->decimal(),
            'date_last_appointment' => $this->typeRegistry->date()
        ];
    }
}