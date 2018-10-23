<?php

namespace api\graphql\base\types\entity;

use api\graphql\core\EntityType;

/**
 * Class AppointmentItemType
 *
 * @package api\graphql\base\types\entity
 */
class AppointmentItemType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'appointment_id' => $this->typeRegistry->id(),
            'service_id' => $this->typeRegistry->id(),
            'service_name' => $this->typeRegistry->string(),
            'service_price' => $this->typeRegistry->float(),
            'service_duration' => $this->typeRegistry->int(),
            'quantity' => $this->typeRegistry->int()
        ];
    }
}