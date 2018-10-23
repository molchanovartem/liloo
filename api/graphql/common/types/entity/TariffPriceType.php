<?php

namespace api\graphql\common\types\entity;

use common\models\TariffPrice;
use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;

/**
 * Class TariffPriceType
 *
 * @package api\graphql\common\types\entity
 */
class TariffPriceType extends \api\graphql\base\types\entity\TariffPriceType implements QueryTypeInterface
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
