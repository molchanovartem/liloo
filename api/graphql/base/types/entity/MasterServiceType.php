<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;

/**
 * Class MasterServiceType
 *
 * @package api\graphql\base\types\entity
 */
class MasterServiceType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'master_id' => $this->typeRegistry->id(),
            'service_id' => $this->typeRegistry->id(),
            'salon_id' => $this->typeRegistry->id()
        ];
    }
}