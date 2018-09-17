<?php

namespace api\schema\type\mutation\input;

use api\schema\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UserUpdateInputType
 *
 * @package api\schema\type\mutation\input
 */
class UserUpdateInputType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        $inputRegistry = $typeRegistry->getMutationInputRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $inputRegistry) {
                return [
                    'login' => $typeRegistry->string(),
                    'password' => $typeRegistry->string(),
                    'profile' => $inputRegistry->userProfileUpdate(),
                    'specializations_id' => $typeRegistry->listOff($typeRegistry->int()),
                    'conveniences_id' => $typeRegistry->listOff($typeRegistry->int()),
                ];
            }
        ]);
    }
}