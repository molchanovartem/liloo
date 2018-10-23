<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;
use api\models\lk\Master;

/**
 * Class MasterType
 *
 * @package api\graphql\lk\types\entity
 */
class MasterType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'masters' => [
                'type' => $typeRegistry->listOff($entityRegistry->master()),
                'description' => 'Коллекция мастеров',
                'args' => [
                    'limit' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30,
                    ],
                    'offset' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 0
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Master::find()
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->allByCurrentAccountId();
                }
            ],
            'master' => [
                'type' => $entityRegistry->master(),
                'description' => 'Мастер',
                'args' => [
                    'id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id()),
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Master::find()
                        ->byCurrentAccountId()
                        ->oneById($args['id']);
                }
            ],
        ];
    }
}