<?php

namespace api\schema\type\mutation\user;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\UserService;

/**
 * Class UserConvenienceType
 *
 * @package api\schema\type\mutation\user
 */
class UserConvenienceType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        return [
            'userConveniencesCreate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'conveniences_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id())),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->createConveniences($args['conveniences_id']);
                }
            ],
            'userConveniencesUpdate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'conveniences_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id())),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->updateConveniences($args['conveniences_id']);
                }
            ],
            'userConveniencesDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'conveniences_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id())),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->deleteConveniences($args['conveniences_id']);
                }
            ],
        ];
    }

}