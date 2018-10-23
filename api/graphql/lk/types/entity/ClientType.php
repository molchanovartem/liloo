<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\QueryTypeInterface;
use api\graphql\core\TypeRegistry;
use api\models\lk\Client;

/**
 * Class ClientType
 *
 * @package api\graphql\lk\types\entity
 */
class ClientType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'clients' => [
                'type' => $typeRegistry->listOff($entityRegistry->client()),
                'description' => 'Коллекция клиентов',
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
                    return Client::find()
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->allByCurrentAccountId();
                }
            ],
            'client' => [
                'type' => $entityRegistry->client(),
                'description' => 'Клиент',
                'args' => [
                    'id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id()),
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Client::find()
                        ->byCurrentAccountId()
                        ->oneById($args['id']);
                }
            ],
        ];
    }
}