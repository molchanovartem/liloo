<?php

namespace api\graphql\common\types\mutation;

use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;
use api\services\common\UserService;

/**
 * Class UserType
 *
 * @package api\graphql\common\types\mutation
 */
class UserType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        return [
            'userLogin' => [
                'type' => $typeRegistry->string(),
                'args' => [
                    'login' => $typeRegistry->nonNull($typeRegistry->string()),
                    'password' => $typeRegistry->nonNull($typeRegistry->string())
                ],
                'resolve' => function ($root, $args) {
                    return (new UserService())->login($args['login'], $args['password']);
                }
            ]
        ];
    }

}