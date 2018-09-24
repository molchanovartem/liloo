<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\models\TariffPrice;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\Tariff;

/**
 * Class TariffType
 *
 * @package api\graphql\lk\types\entity
 */
class TariffType extends ObjectType implements QueryTypeInterface
{
    /**
     * TariffType constructor.
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'name' => $typeRegistry->string(),
                    'description' => $typeRegistry->string(),
                    'type' => $typeRegistry->int(),
                    'status' => $typeRegistry->int(),
                    'quantity' => $typeRegistry->int(),
                    'price' => [
                        'type' => $entityRegistry->tariffPrice(),
                        'args' => [
                            'id' => $typeRegistry->nonNull($typeRegistry->id())
                        ],
                        'resolve' => function (Tariff $model, $args) {
                            return TariffPrice::find()
                                ->byId($args['id'])
                                ->byTariffId($model->id)
                                ->one();
                        }
                    ],
                    'prices' => [
                        'type' => $typeRegistry->listOff($entityRegistry->tariffPrice()),
                        'resolve' => function (Tariff $tariff, $args, $context, $info) {
                            return TariffPrice::find()
                                ->where(['tariff_id' => $tariff->id])
                                ->all();
                        }
                    ],
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
            'tariffs' => [
                'type' => $typeRegistry->listOff($entityRegistry->tariff()),
                'description' => 'Коллекция тарифов',
                'args' => [
                    'status' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => null
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Tariff::find()->allByParams($args['status']);
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
                    return Tariff::find()->byId($args['id'])->one();
                }
            ],
        ];
    }
}