<?php

namespace api\graphql\lk\types\entity;

use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use api\models\lk\Service;

/**
 * Class ServiceType
 *
 * @package api\graphql\lk\types\entity
 */
class ServiceType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'services' => [
                'type' => $typeRegistry->listOff($entityRegistry->service()),
                'description' => 'Коллекция услуг',
                'args' => [
                    'parent_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null,
                    ],
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
                    return Service::find()
                        ->where(['parent_id' => $args['parent_id']])
                        ->isService()
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->allByCurrentAccountId();
                }
            ],
            'service' => [
                'type' => $entityRegistry->service(),
                'args' => [
                    'id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id())
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Service::find()
                        ->byCurrentAccountId()
                        ->oneById($args['id']);
                }
            ],
        ];
    }


}