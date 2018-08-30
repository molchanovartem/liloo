<?php

namespace api\schema\type\mutation\input;

use api\schema\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UserProfileUpdateInputType
 *
 * @package api\schema\type\mutation\input
 */
class UserProfileUpdateInputType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->string(),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date()
                ];
            }
        ]);
    }
}