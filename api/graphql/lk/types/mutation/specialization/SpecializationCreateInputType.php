<?php

namespace api\graphql\lk\types\mutation\specialization;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class SpecializationCreateInputType
 *
 * @package api\graphql\lk\types\mutation\specialization
 */
class SpecializationCreateInputType extends InputObjectType
{
    /**
     * SpecializationCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                    'description' => $typeRegistry->string(),
                ];
            }
        ]);
    }
}