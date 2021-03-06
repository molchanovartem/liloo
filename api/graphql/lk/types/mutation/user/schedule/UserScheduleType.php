<?php

namespace api\graphql\lk\types\mutation\user\schedule;

use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\lk\services\UserService;

/**
 * Class UserScheduleType
 *
 * @package api\graphql\lk\types\mutation\user\schedule
 */
class UserScheduleType implements MutationFieldsTypeInterface
{
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $inputType = $typeRegistry->getMutationRegistry();
        $entityType = $typeRegistry->getEntityRegistry();

        return [
            'userScheduleCreate' => [
                'type' => $entityType->userSchedule(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputType->userScheduleCreate()),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->createUserSchedule($args['attributes']);
                }
            ],
            'userSchedulesCreate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'items' => $typeRegistry->nonNull($typeRegistry->listOff($inputType->userScheduleCreate()))
                ],
                'resolve' => function ($root, $args) {
                    return (new UserService())->createUserSchedules($args['items']);
                }
            ],
            'userScheduleUpdate' => [
                'type' => $entityType->userSchedule(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputType->userScheduleUpdate()),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->updateUserSchedule($args['id'], $args['attributes']);
                }

            ],
            'userScheduleDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->deleteUserSchedule($args['id']);
                }
            ],
        ];
    }

}