<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\QueryTypeInterface;
use api\graphql\core\TypeRegistry;
use api\models\lk\Client;
use GraphQL\Type\Definition\InputObjectType;
use yii\helpers\ArrayHelper;

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
        $filterType = new InputObjectType([
            'name' => 'ClientFilter',
            'fields' => function() use ($typeRegistry) {
                return [
                    'phone_contains' => $typeRegistry->string(),
                    'surname_contains' => $typeRegistry->string(),
                ];
            }
        ]);

        return [
            'clients' => [
                'type' => $typeRegistry->listOff($entityRegistry->client()),
                'description' => 'Коллекция клиентов',
                'args' => [
                    'filter' => $filterType,
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
                    $query = Client::find()->limit($args['limit'])->offset($args['offset']);
                    if ($phone = ArrayHelper::getValue($args, 'filter.phone_contains')) {
                        $query->andWhere(['like','phone', $phone]);
                    }

                    if ($surname = ArrayHelper::getValue($args, 'filter.surname_contains')) {
                        $query->andWhere(['like', 'surname', $surname]);
                    }

                    return $query->allByCurrentAccountId();
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
            'clientTotalCount' => [
                'type' => $typeRegistry->int(),
                'resolve' => function ($root, $args) {
                    return Client::find()->countByCurrentAccountId();
                }
            ]
        ];
    }
}
