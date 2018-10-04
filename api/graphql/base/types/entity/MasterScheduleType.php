<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;

/**
 * Class MasterScheduleType
 *
 * @package api\graphql\base\types\entity
 */
class MasterScheduleType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'master_id' => $this->typeRegistry->id(),
            'salon_id' => $this->typeRegistry->id(),
            'type' => $this->typeRegistry->int(),
            'start_date' => $this->typeRegistry->dateTime(),
            'end_date' => $this->typeRegistry->dateTime()
        ];
    }
}