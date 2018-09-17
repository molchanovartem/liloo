<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use api\models\Client;

/**
 * Class ClientType
 *
 * @package api\graphql\lk\types\entity
 */
class ClientType extends ObjectType implements QueryTypeInterface
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        parent::__construct($config = [
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'user_id' => $typeRegistry->id(),
                    'country_id' => $typeRegistry->id(),
                    'city_id' => $typeRegistry->id(),
                    'status' => $typeRegistry->int(),
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->string(),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'phone' => $typeRegistry->string(),
                    'address' => $typeRegistry->string(),
                    'total_appointment' => $typeRegistry->int(),
                    'total_failure_appointment' => $typeRegistry->int(),
                    'total_spent_money' => $typeRegistry->decimal(),
                    'date_last_appointment' => $typeRegistry->date()
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
                    return Client::find()->allByParams($args['limit'], $args['offset']);
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
                    return Client::find()->oneById($args['id']);
                }
            ],
        ];
    }
}