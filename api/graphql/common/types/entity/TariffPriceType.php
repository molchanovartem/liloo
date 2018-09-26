<?php

namespace api\graphql\common\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use common\models\TariffPrice;

/**
 * Class TariffPriceType
 *
 * @package api\graphql\common\types\entity
 */
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
                    return TariffPrice::find()->oneById($args['id']);
                }
            ],
        ];
    }
}
