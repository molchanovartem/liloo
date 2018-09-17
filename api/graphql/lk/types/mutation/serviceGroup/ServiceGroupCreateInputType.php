<?php

namespace api\graphql\lk\types\mutation\serviceGroup;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class ServiceGroupCreateInputType
 *
 * @package api\graphql\lk\types\mutation\serviceGroup
 */
class ServiceGroupCreateInputType extends InputObjectType
{
    /**
     * ServiceGroupCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'parent_id' => $typeRegistry->id(),
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                ];
            }
        ]);
    }
}