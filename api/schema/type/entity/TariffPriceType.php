<?php

namespace api\schema\type\entity;

use api\schema\registry\TypeRegistry;
use common\models\TariffPrice;
use GraphQL\Type\Definition\ObjectType;
use api\schema\type\QueryTypeInterface;

class TariffPriceType extends ObjectType implements QueryTypeInterface
{
    /**
     * QueryTypeInterface constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'tariff_id' => $typeRegistry->id(),
                    'price' => $typeRegistry->float(),
                    'days' => $typeRegistry->int(),
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
            'tariffPrices' => [
                'type' => $typeRegistry->listOff($entityRegistry->tariffPrice()),
                'description' => 'Коллекция цен тарифов',
                'resolve' => function ($root, $args) {
                    return TariffPrice::find()->all();
                }
            ],
            'tariffPrice' => [
                'type' => $entityRegistry->tariffPrice(),
                'description' => 'Цены тарифа',
                'args' => [
                    'id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id()),
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return TariffPrice::find()->byId($args['id'])->one();
                }
            ],
        ];
    }
}
