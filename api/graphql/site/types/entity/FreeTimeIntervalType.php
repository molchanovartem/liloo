<?php

namespace api\graphql\site\types\entity;

use api\graphql\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class FreeTimeIntervalType
 * @package api\graphql\site\types\entity
 */
class FreeTimeIntervalType extends ObjectType
{
    /**
     * FreeTimeIntervalType constructor.
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'start_time' => $typeRegistry->dateTime(),
                    'end_time' => $typeRegistry->dateTime(),
                ];
            }
        ]);
    }
}
