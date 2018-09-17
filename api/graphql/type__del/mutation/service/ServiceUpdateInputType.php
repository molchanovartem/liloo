<?php

namespace api\schema\type\mutation\service;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class ServiceUpdateInputType
 *
 * @package api\schema\type\mutation\service
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