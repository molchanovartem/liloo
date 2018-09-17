<?php

namespace api\schema\type\mutation\specialization;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class SpecializationUpdateInputType
 *
 * @package api\schema\type\mutation\specialization
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