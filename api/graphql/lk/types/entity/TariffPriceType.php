<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;
use common\models\TariffPrice;

/**
 * Class TariffPriceType
 *
 * @package api\graphql\lk\types\entity
 */
class TariffPriceType implements QueryTypeInterface
{
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
                'description' => 'Цена тарифа',
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
