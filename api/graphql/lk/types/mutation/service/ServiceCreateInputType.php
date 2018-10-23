<?php

namespace api\graphql\lk\types\mutation\service;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\core\TypeRegistry;

/**
 * Class ServiceCreateInputType
 *
 * @package api\graphql\lk\types\mutation\service
 */
class ServiceCreateInputType extends InputObjectType
{
    /**
     * ServiceCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'parent_id' => $typeRegistry->id(),
                    'specialization_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                    'price' => $typeRegistry->nonNull($typeRegistry->decimal()),
                    'duration' => $typeRegistry->nonNull($typeRegistry->int())
                ];
            }
        ]);
    }
}