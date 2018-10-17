<?php

namespace api\graphql\common\types\entity;

use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use api\services\common\FreeTimeService;

/**
 * Class FreeTimeType
 *
 * @package api\graphql\common\types\entity
 */
class FreeTimeType implements QueryTypeInterface
{
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        return [
            'userFreeTimes' => [
                'type' => $typeRegistry->listOff($typeRegistry->string()),
                'args' => [
                    'user_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'date' => $typeRegistry->nonNull($typeRegistry->date()),
                    'period' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30
                    ],
                    'unaccountedTime' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => null
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return (new FreeTimeService())->getUserFreeTime($args['user_id'], $args['date'], $args['period'], $args['unaccountedTime']);
                }
            ],
            'masterFreeTimes' => [
                'type' => $typeRegistry->listOff($typeRegistry->string()),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'date' => $typeRegistry->nonNull($typeRegistry->date()),
                    'period' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30
                    ],
                    'unaccountedTime' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => null
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return (new FreeTimeService())->getMasterFreeTime($args['master_id'], $args['date'], $args['period'], $args['unaccountedTime']);
                }
            ]
        ];
    }
}