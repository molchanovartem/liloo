<?php

namespace api\schema\type\mutation\user;

use GraphQL\Type\Definition\InputObjectType;
use api\schema\registry\TypeRegistry;

/**
 * Class UserCreateInputType
 *
 * @package api\schema\type\mutation\user
 */
class UserCreateInputType extends InputObjectType
{
    /**
     * UserCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $inputRegistry = $typeRegistry->getMutationInputRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $inputRegistry) {
                return [
                    'type' => $typeRegistry->nonNull($typeRegistry->int()),
                    'login' => $typeRegistry->nonNull($typeRegistry->string()),
                    'password' => $typeRegistry->nonNull($typeRegistry->string()),
                    'specializations_id' => $typeRegistry->listOff($typeRegistry->id()),
                    'conveniences_id' => $typeRegistry->listOff($typeRegistry->id()),
                    'profile' => $typeRegistry->nonNull($inputRegistry->userCreateProfile())
                ];
            }
        ]);
    }
}