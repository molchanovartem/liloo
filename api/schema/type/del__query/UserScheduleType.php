<?php

namespace api\schema\type\query;

use GraphQL\Type\Definition\ObjectType;
use api\models\UserSchedule;
use api\schema\TypeRegistry;

/**
 * Class UserSchedule
 * @package api\schema\query
 */
class UserScheduleType extends ObjectType implements QueryTypeInterface
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'user_id' => $typeRegistry->id(),
                    'type' => $typeRegistry->int(),
                    'start_date' => $typeRegistry->dateTime(),
                    'end_date' => $typeRegistry->dateTime()
                ];
            }
        ]);
    }

    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $queryRegistry = $typeRegistry->getQueryRegistry();

        return [
            'userSchedules' => [
                'type' => $typeRegistry->listOff($queryRegistry->userSchedule()),
                'args' => [
                    'user_id' => $typeRegistry->nonNull($typeRegistry->id()),
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
                ],
                'resolve' => function ($root, $args) {
                    return UserSchedule::find()->allByParams($args['user_id'], $args['start_date'], $args['end_date']);
                }
            ],
            'userSchedule' => [
                'type' => $queryRegistry->userSchedule(),
                'args' => ['id' => $typeRegistry->nonNull($typeRegistry->id())],
                'resolve' => function ($root, $args) {
                    return UserSchedule::find()->oneById($args['id']);
                }
            ]
        ];
    }


}