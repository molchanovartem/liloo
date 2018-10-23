<?php

namespace api\graphql\lk\types\mutation\user;

use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\lk\services\UserService;

/**
 * Class UserSpecializationType
 *
 * @package api\graphql\lk\types\mutation\user
 */
class UserSpecializationType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        return [
            'userSpecializationsCreate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'specializations_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args) {
                    return (new UserService())->createSpecializations($args['specializations_id']);
                }
            ],
            'userSpecializationsUpdate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'specializations_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->updateSpecializations($args['specializations_id']);
                }
            ],
            'userSpecializationsDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'specializations_id' => $typeRegistry->listOff($typeRegistry->id())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->deleteSpecializations($args['specializations_id']);
                }
            ],
        ];
    }

}