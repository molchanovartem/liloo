<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use api\models\UserSchedule;

/**
 * Class UserScheduleType
 *
 * @package api\graphql\lk\types\entity
 */
class UserScheduleType extends ObjectType implements QueryTypeInterface
{
    /**
     * UserScheduleType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
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
                ],
                'resolve' => function ($root, $args) {
                    return UserSchedule::find()->allByParams($args['start_date'], $args['end_date']);
                }
            ],
            'userSchedule' => [
                'type' => $entityRegistry->userSchedule(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return UserSchedule::find()->oneById($args['id']);
                }
            ]
        ];
    }


}