<?php

namespace api\schema\type\mutation\user;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UserUpdateInputType
 *
 * @package api\schema\type\mutation\user
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
        $inputRegistry = $typeRegistry->getMutationInputRegistry();

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