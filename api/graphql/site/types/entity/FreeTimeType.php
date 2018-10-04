<?php

namespace api\graphql\site\types\entity;

use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use common\helpers\FreeDateTime;
use api\services\site\ExecutorService;
use GraphQL\Type\Definition\InputObjectField;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;

/**
 * Class FreeTimeType
 *
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
                    'user_id' => $typeRegistry->id(),
                    'master_id' => $typeRegistry->id(),
                    'intervals' => $typeRegistry->listOff($entityRegistry->freeTimeInterval()),
                    'periods' => [
                        'type' => $typeRegistry->listOff($typeRegistry->string()),
                        'args' => [
                            'minute' => $typeRegistry->nonNull($typeRegistry->int())
                        ]
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }

    /**
     * @param TypeRegistry $typeRegistry
     *
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'freeTimes' => [
                'type' => $typeRegistry->listOff($entityRegistry->freeTime()),
                'description' => 'Свободное время',
                'args' => [
                    'users_id' => [
                        'type' => $typeRegistry->listOff($typeRegistry->id()),
                        'defaultValue' => null,
                    ],
                    'masters_id' => [
                        'type' => $typeRegistry->listOff($typeRegistry->id()),
                        'defaultValue' => null,
                    ],
                    'services_id' => [
                        'type' => $typeRegistry->listOff($typeRegistry->id()),
                        'defaultValue' => [],
                    ],
                    'date' => [
                        'type' => $typeRegistry->date(),
                    ],
                ],
                'resolve' => function ($root, $args) {
                    return [
                        'items' => [['start_time' => '123123', 'end_time' => '21321 21 3']],
                        'periods' => ['2018-10-234', '324 234 234 ']
                    ];

//            $isSalon = empty($args['user_id']);
//                    $executorId = $isSalon ? $args['master_id'] : $args['user_id'];
//                    $executorService = new ExecutorService();
//
//                    if (empty($args['services_id'])) {
//                        return $executorService->getFreeTime($isSalon, $executorId, $args['date']);
//                    }
//                    $serviceTime = $executorService->getServiceSumTimeInSecond($args['services_id']);
//
//                    return $executorService->getFreeWithServiceTime($isSalon, $executorId, $args['date'], $serviceTime);
                },
            ],
            'freeTime' => [
                'type' => $entityRegistry->freeTime(),
                'description' => 'Свободное время',
                'args' => [
                    'user_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null,
                    ],
                    'master_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null,
                    ],
                    'services_id' => [
                        'type' => $typeRegistry->listOff($typeRegistry->id()),
                        'defaultValue' => [],
                    ],
                    'date' => [
                        'type' => $typeRegistry->date(),
                    ],
                ],
                'resolve' => function ($root, $args) {
                    return [
                        'items' => [['start_time' => '123123', 'end_time' => '21321 21 3']],
                        'periods' => ['2018-10-234', '324 234 234 ']
                    ];

                },
            ],
        ];
    }
}
