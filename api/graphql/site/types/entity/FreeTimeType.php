<?php

namespace api\graphql\site\types\entity;

use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use api\models\Appointment;
use api\models\MasterSchedule;
use api\models\UserSchedule;
use common\services\ExecutorService;
use GraphQL\Error\Error;

/**
 * Class FreeTimeType
 *
 * @package api\graphql\site\types\entity
 */
class FreeTimeType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     *
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        return [
            'freeTime' => [
                'type' => $typeRegistry->listOff($typeRegistry->string()),
                'description' => 'Свободное время',
                'args' => [
                    'user_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null,
                    ],
                    'salon_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null,
                    ],
                    'master_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null,
                    ],
                    'service_id' => [
                        'type' => $typeRegistry->listOff($typeRegistry->id()),
                        'defaultValue' => [],
                    ],
                    'date' => [
                        'type' => $typeRegistry->date(),
                    ],
                ],
                'resolve' => function ($root, $args) {
                    $executorService = new ExecutorService();
                    $serviceSumTime = $executorService->getServiceSumTime($args['service_id']);
                    $currentTime = sprintf('%02d:%02d', floor($serviceSumTime / 60), $serviceSumTime % 60);
                    $isSalon = empty($args['user_id']);
                    $time = $isSalon ?
                        $executorService->getCurrentTimeSalonMaster($args['master_id'], $args['date']) :
                        $executorService->getCurrentTime($args['user_id'], $args['date']);

                    if (empty($args['service_id'])) {
                        return $time;
                    }

                    $appointments = $isSalon ?
                        Appointment::find()
                                   ->select(['start_date', 'end_date'])
                                   ->where(['master_id' => $args['master_id']])
                                   ->all() :
                        Appointment::find()
                                   ->select(['start_date', 'end_date'])
                                   ->where(['user_id' => $args['user_id']])
                                   ->all();

                    $schedule = $isSalon ?
                        MasterSchedule::find()
                                      ->where(['master_id' => $args['master_id']])
                                      ->andWhere(['date(end_date)' => $args['date']])
                                      ->orderBy('end_date')
                                      ->asArray()
                                      ->all() :
                        UserSchedule::find()
                                    ->where(['user_id' => $args['user_id']])
                                    ->andWhere(['date(end_date)' => $args['date']])
                                    ->orderBy('end_date')
                                    ->asArray()
                                    ->all();

                    return $executorService->getFreePartTime($time, $appointments, $currentTime, $args['date'], $schedule);
                },
            ],
        ];
    }
}
