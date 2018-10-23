<?php

namespace api\graphql\site\types;

use api\graphql\common\types\mutation\UserType;
use api\graphql\site\types\mutation\appointment\AppointmentType;
use GraphQL\Type\Definition\ObjectType;
use api\graphql\core\TypeRegistry;

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
                    UserType::getMutationFieldsType($typeRegistry),
                    AppointmentType::getMutationFieldsType($typeRegistry)
                );
            }
        ]);
    }
}
