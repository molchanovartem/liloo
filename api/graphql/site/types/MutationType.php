<?php

namespace api\graphql\site\types;

use api\graphql\common\types\mutation\UserType;
use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;

/**
 * Class MutationType
 *
 * @package api\graphql\common\types
 */
class MutationType extends ObjectType
{
    /**
     * MutationType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return array_merge(
                    UserType::getMutationFieldsType($typeRegistry)
                );
            }
        ]);
    }
}
