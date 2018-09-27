<?php

namespace api\graphql\site\types\entity;

use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use site\services\ExecutorService;

/**
 * Class FreeTimeType
 * @package api\graphql\site\types\entity
 */
class FreeTimeType extends ObjectType implements QueryTypeInterface
{

    /**
     * QueryTypeInterface constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        $config = [
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
//                    'user_id' => $typeRegistry->id(),
//                    'salon_id' => $typeRegistry->id(),
//                    'master_id' => $typeRegistry->id(),
//                    'date' => $typeRegistry->date(),
//                    'service_id' => $typeRegistry->listOff($typeRegistry->id()),
                    'time' => $typeRegistry->string(),
                ];
            }
        ];

        parent::__construct($config);
    }

    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'freeTime' => [
                'type' => $typeRegistry->listOff($entityRegistry->freeTime()),
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
                        'defaultValue' => null,
                    ],
                    'date' => [
                        'type' => $typeRegistry->date(),
                    ],
                ],
                'resolve' => function ($root, $args) {
                    if (!empty($args['user_id'])) {
                        if (empty($args['service_id'])) {
                            return (new ExecutorService())->getCurrentTime($args['user_id'], $args['date']);
                        }

                        $executorService = new ExecutorService();
                        $serviceSumTime = $executorService->getServiceSumTime($args['service_id']);
                        $currentTime = sprintf('%02d:%02d', floor($serviceSumTime / 60), $serviceSumTime % 60);

                        $sessionEndTime = date('H:i', strtotime('13:00') + strtotime($currentTime) - strtotime("00:00:00"));
                        $freeTime = $executorService->getCurrentTime($args['user_id'], $args['date']);
                        foreach ($freeTime as $t) {
                            $endSession = date('H:i', strtotime($t) + strtotime($currentTime) - strtotime("00:00:00"));


                        }
                    }

                    return (new ExecutorService())->getCurrentTimeSalonMaster($args['master_id'], $args['date']);
                }
            ],
        ];
    }
}