<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;

/**
 * Class AppointmentType
 *
 * @package api\graphql\base\types\entity
 */
class AppointmentType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'account_id' => $this->typeRegistry->id(),
            'user_id' => $this->typeRegistry->id(),
            'salon_id' => $this->typeRegistry->id(),
            'master_id' => $this->typeRegistry->id(),
            'client_id' => $this->typeRegistry->id(),
            'owner_id' => $this->typeRegistry->id(),
            'status' => $this->typeRegistry->int(),
            'start_date' => $this->typeRegistry->dateTime(),
            'end_date' => $this->typeRegistry->dateTime(),
        ];
    }
}