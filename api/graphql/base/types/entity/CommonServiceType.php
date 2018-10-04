<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;

/**
 * Class CommonServiceType
 *
 * @package api\graphql\common\types\entity
 */
class CommonServiceType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'account_id' => $this->typeRegistry->id(),
            'parent_id' => $this->typeRegistry->id(),
            'specialization_id' => $this->typeRegistry->id(),
            'name' => $this->typeRegistry->string(),
            'price' => $this->typeRegistry->string(),
            'duration' => $this->typeRegistry->int(),
        ];
    }
}