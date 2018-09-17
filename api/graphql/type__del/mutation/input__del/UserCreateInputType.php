<?php

namespace api\schema\type\mutation\input;

use api\schema\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

class UserCreateInputType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        $inputRegistry = $typeRegistry->getMutationInputRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $inputRegistry) {
                return [
                    'type' => $typeRegistry->nonNull($typeRegistry->int()),
                    'login' => $typeRegistry->nonNull($typeRegistry->string()),
                    'password' => $typeRegistry->nonNull($typeRegistry->string()),
                    'specializations_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->int())),
                    'conveniences_id' => $typeRegistry->listOff($typeRegistry->int()),
                    'profile' => $typeRegistry->nonNull($inputRegistry->userCreateProfile())
                ];
            }
        ]);
    }
}