<?php

namespace api\graphql\lk\types\mutation\specialization;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class SpecializationUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\specialization
 */
class SpecializationUpdateInputType extends InputObjectType
{
    /**
     * SpecializationUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'name' => $typeRegistry->string(),
                    'description' => $typeRegistry->string()
                ];
            }
        ]);
    }
}