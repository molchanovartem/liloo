<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;

/**
 * Class ConvenienceType
 *
 * @package api\graphql\base\types\entity
 */
class ConvenienceType extends EntityType
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
                'type' => $this->typeRegistry->int(),
                'description' => 'Описание'
            ]
        ];
    }
}