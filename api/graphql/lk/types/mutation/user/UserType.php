<?php

namespace api\graphql\lk\types\mutation\user;

use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;
use api\services\UserService;

/**
 * Class UserType
 *
 * @package api\graphql\lk\types\mutation\user
 */
class UserType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $inputType = $typeRegistry->getMutationInputRegistry();
        $entityType = $typeRegistry->getEntityRegistry();

        return [
            'userCreate' => [
                'type' => $entityType->user(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputType->userCreate())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->create($args['attributes']);
                }
            ],
            'userUpdate' => [
                'type' => $entityType->user(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputType->userUpdate())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->update($args['attributes']);
                }
            ],
        ];
    }

}