<?php

namespace api\graphql\base\types\entity;

use api\graphql\core\EntityType;

/**
 * Class SpecializationType
 *
 * @package api\graphql\base\types\entity
 */
class SpecializationType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'name' => [
                'type' => $this->typeRegistry->string(),
                'description' => 'Название'
            ],
            'description' => [
                'type' => $this->typeRegistry->string(),
                'description' => 'Описание'
            ]
        ];
    }
}