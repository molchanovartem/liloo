<?php

namespace api\graphql\lk\types\mutation\user;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class UserUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\user
 */
class UserUpdateInputType extends InputObjectType
{
    /**
     * UserUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $inputRegistry = $typeRegistry->getMutationRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $inputRegistry) {
                return [
                    'login' => $typeRegistry->string(),
                    'password' => $typeRegistry->string(),
                    'profile' => $inputRegistry->userProfileUpdate(),
                    'specializations_id' => $typeRegistry->listOff($typeRegistry->id()),
                    'conveniences_id' => $typeRegistry->listOff($typeRegistry->id()),
                ];
            }
        ]);
    }
}