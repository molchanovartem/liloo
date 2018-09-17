<?php

namespace api\schema\type\mutation\input;


use api\schema\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

class UserCreateProfileInputType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date()
                ];
            }
        ]);
    }
}