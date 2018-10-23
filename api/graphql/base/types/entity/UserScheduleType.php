<?php

namespace api\graphql\base\types\entity;

use api\graphql\core\EntityType;

/**
 * Class UserScheduleType
 *
 * @package api\graphql\base\types\entity
 */
class UserScheduleType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'user_id' => $this->typeRegistry->id(),
            'type' => $this->typeRegistry->int(),
            'start_date' => $this->typeRegistry->dateTime(),
            'end_date' => $this->typeRegistry->dateTime()
        ];
    }
}