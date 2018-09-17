<?php

namespace api\schema\type\entity;

use api\models\Tariff;
use api\schema\registry\TypeRegistry;
use common\models\TariffPrice;
use GraphQL\Type\Definition\ObjectType;
use api\schema\type\QueryTypeInterface;

/**
 * Class TariffType
 * @package api\schema\type\entity
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
                'resolve' => function ($root, $args) {
                    return Tariff::find()->all();
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