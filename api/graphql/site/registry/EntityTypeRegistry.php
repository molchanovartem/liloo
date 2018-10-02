<?php

namespace api\graphql\site\registry;

use api\graphql\AdditionalTypeRegistry;
use api\graphql\site\types\entity\FreeTimeIntervalType;
use api\graphql\site\types\entity\FreeTimeType;
use api\graphql\site\types\entity\ServiceType;

/**
 * Class EntityTypeRegistry
 * @package api\graphql\site\registry
 */
class EntityTypeRegistry extends AdditionalTypeRegistry
{
    public function service()
    {
        return $this->typeRegistry->get(ServiceType::class);
    }

    public function freeTime()
    {
        return $this->typeRegistry->get(FreeTimeType::class);
    }

    public function freeTimeInterval()
    {
        return $this->typeRegistry->get(FreeTimeIntervalType::class);
    }
}
