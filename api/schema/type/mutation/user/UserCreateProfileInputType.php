<?php

namespace api\schema\type\mutation\user;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UserCreateProfileInputType
 *
 * @package api\schema\type\mutation\user
 */
class UserCreateProfileInputType extends InputObjectType
{
    /**
     * UserCreateProfileInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'description' => $typeRegistry->string()
                ];
            }
        ]);
    }
}