<?php

namespace api\schema\type\mutation\user\schedule;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\UserService;

/**
 * Class UserScheduleType
 *
 * @package api\schema\type\mutation\user\schedule
 */
class UserScheduleType implements MutationFieldsTypeInterface
{
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $inputType = $typeRegistry->getMutationInputRegistry();
        $entityType = $typeRegistry->getEntityRegistry();

        return [
            'userScheduleCreate' => [
                'type' => $entityType->userSchedule(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputType->userScheduleCreate()),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->createSchedule($args['attributes']);
                }
            ],
            'userScheduleUpdate' => [
                'type' => $entityType->userSchedule(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputType->userScheduleUpdate()),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->updateSchedule($args['id'], $args['attributes']);
                }

            ],
            'userScheduleDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new UserService())->deleteSchedule($args['id']);
                }
            ],
        ];
    }

}