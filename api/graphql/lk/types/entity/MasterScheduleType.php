<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\MasterSchedule;

/**
 * Class MasterScheduleType
 *
 * @package api\graphql\lk\types\entity
 */
class MasterScheduleType extends ObjectType implements QueryTypeInterface
{
    /**
     * MasterScheduleType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'master_id' => $typeRegistry->id(),
                    'salon_id' => $typeRegistry->id(),
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
            'masterSchedules' => [
                'type' => $typeRegistry->listOff($entityRegistry->masterSchedule()),
                'args' => [
                    'master_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null
                    ],
                    'salon_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null
                    ],
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
                    return MasterSchedule::find()->allByParams($args['start_date'], $args['end_date'], $args['salon_id'], $args['master_id']);
                }
            ],
            'masterSchedule' => [
                'type' => $entityRegistry->masterSchedule(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return MasterSchedule::find()->oneById($args['id']);
                }
            ]
        ];
    }

}