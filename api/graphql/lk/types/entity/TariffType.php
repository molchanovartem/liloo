<?php

namespace api\graphql\lk\types\entity;

use common\models\Tariff;
use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;

/**
 * Class TariffType
 *
 * @package api\graphql\lk\types\entity
 */
class TariffType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'tariffs' => [
                'type' => $typeRegistry->listOff($entityRegistry->tariff()),
                'description' => 'Коллекция тарифов',
                'args' => [
                    'status' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => null
                    ],
                    'limit' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30,
                    ],
                    'offset' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 0,
                    ],
                ],
                'resolve' => function ($root, $args) {
                    return Tariff::find()
                        ->andFilterWhere(['status' => $args['status']])
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->all();
                }
            ],
            'tariff' => [
                'type' => $entityRegistry->tariff(),
                'description' => 'Тариф',
                'args' => [
                    'id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id()),
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Tariff::find()->oneById($args['id']);
                }
            ],
        ];
    }
}