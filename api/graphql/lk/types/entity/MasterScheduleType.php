<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;
use api\models\lk\MasterSchedule;

/**
 * Class MasterScheduleType
 *
 * @package api\graphql\lk\types\entity
 */
class MasterScheduleType implements QueryTypeInterface
{
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
                    return MasterSchedule::find()
                        ->where(['between', 'start_date', $args['start_date'], $args['end_date']])
                        ->andFilterWhere(['salon_id' => $args['salon_id'], 'master_id' => $args['master_id']])
                        ->allByCurrentAccountId();
                }
            ],
            'masterSchedule' => [
                'type' => $entityRegistry->masterSchedule(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return MasterSchedule::find()
                        ->byCurrentAccountId()
                        ->oneById($args['id']);
                }
            ]
        ];
    }

}