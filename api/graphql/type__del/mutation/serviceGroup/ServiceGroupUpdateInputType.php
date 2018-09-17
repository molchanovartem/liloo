<?php

namespace api\schema\type\mutation\serviceGroup;


use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class ServiceGroupUpdateInputType
 *
 * @package api\schema\type\mutation\serviceGroup
 */
class ServiceGroupUpdateInputType extends InputObjectType
{
    /**
     * ServiceGroupUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'parent_id' => $typeRegistry->id(),
                    'name' => $typeRegistry->string(),
                ];
            }
        ]);
    }
}