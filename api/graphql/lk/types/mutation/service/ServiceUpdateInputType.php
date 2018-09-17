<?php

namespace api\graphql\lk\types\mutation\service;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class ServiceUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\service
 */
class ServiceUpdateInputType extends InputObjectType
{
    /**
     * ServiceUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'parent_id' => $typeRegistry->id(),
                    'specialization_id' => $typeRegistry->id(),
                    'name' => $typeRegistry->string(),
                    'price' => $typeRegistry->decimal(),
                    'duration' => $typeRegistry->int()
                ];
            }
        ]);
    }
}