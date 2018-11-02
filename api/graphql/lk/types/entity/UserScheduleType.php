<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\QueryTypeInterface;
use api\graphql\core\TypeRegistry;
use api\models\lk\UserSchedule;

/**
 * Class UserScheduleType
 *
 * @package api\graphql\lk\types\entity
 */
class UserScheduleType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'userSchedules' => [
                'type' => $typeRegistry->listOff($entityRegistry->userSchedule()),
                'args' => [
                    'start_date' => [
                        'type' => $typeRegistry->dateTime(),
                        'description' => 'Дата начала, формат "Y-m-d H:i:s"',
                        'defaultValue' => date('Y-m-01 00:00:00')
                    ],
                    'end_date' => [
                        'type' => $typeRegistry->dateTime(),
                        'description' => 'Дата окончания, формат "Y-m-d H:i:s"',
                        'defaultValue' => date('Y-m-t 23:59:59')
                    ],
                    'limit' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30,
                    ],
                    'offset' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 0,
                    ],
                ],
                'resolve' => function ($root, $args) {
                    return UserSchedule::find()
                        ->where(['between', 'start_date', $args['start_date'], $args['end_date']])
                        ->byCurrentUserId()
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->all();
                }
            ],
            'userSchedule' => [
                'type' => $entityRegistry->userSchedule(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return UserSchedule::find()
                        ->byCurrentAccountId()
                        ->oneById($args['id']);
                }
            ]
        ];
    }


}