<?php

namespace api\schema\type\query;

use api\models\Client;
use api\schema\registry\TypeRegistry;
use api\schema\type\QueryTypeInterface;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class ClientType
 *
 * @package api\schema\type\entity
 */
class ClientType extends ObjectType implements QueryTypeInterface
{
    /**
     * ClientType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'account_id' => $typeRegistry->id(),
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->string(),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => [
                        'type' => $typeRegistry->string(),
                        'description' => 'Дата рождения',
                        'args' => [
                            'format' => [
                                'type' => $typeRegistry->string(),
                                'description' => 'Формат (PHP) даты'
                            ]
                        ],
                        'resolve' => function ($client, $args) {
                            if (isset($args['format']) && $client['date_birth'] !== null) {
                                return date($args['format'], strtotime($client['date_birth']));
                            }
                            return $client['date_birth'];
                        }
                    ],
                    'phone' => $typeRegistry->string(),
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