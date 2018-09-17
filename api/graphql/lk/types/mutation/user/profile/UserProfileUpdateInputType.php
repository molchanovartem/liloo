<?php

namespace api\graphql\lk\types\mutation\user\profile;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class UserProfileUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\user\profile
 */
class UserProfileUpdateInputType extends InputObjectType
{
    /**
     * UserProfileUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->string(),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'description' => $typeRegistry->string(),
                    'phone' => $typeRegistry->string()
                ];
            }
        ]);
    }
}