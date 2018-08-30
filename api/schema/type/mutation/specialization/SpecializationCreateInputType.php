<?php

namespace api\schema\type\mutation\specialization;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class SpecializationCreateInputType
 *
 * @package api\schema\type\mutation\specialization
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
                    'description' => $typeRegistry->string()
                ];
            }
        ]);
    }
}