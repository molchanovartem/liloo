<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;

/**
 * Class MasterSpecializationType
 *
 * @package api\graphql\base\types\entity
 */
class MasterSpecializationType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'master_id' => $this->typeRegistry->id(),
            'specialization_id' => $this->typeRegistry->id()
        ];
    }
}