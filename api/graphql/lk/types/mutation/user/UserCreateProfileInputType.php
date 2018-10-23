<?php

namespace api\graphql\lk\types\mutation\user;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\core\TypeRegistry;

/**
 * Class UserCreateProfileInputType
 *
 * @package api\graphql\lk\types\mutation\user
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
                    'country_id' => $typeRegistry->id(),
                    'city_id' => $typeRegistry->id(),
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'description' => $typeRegistry->string(),
                    'phone' => $typeRegistry->nonNull($typeRegistry->string()),
                    'address' => $typeRegistry->string(),
                ];
            }
        ]);
    }
}