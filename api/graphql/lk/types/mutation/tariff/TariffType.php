<?php

namespace api\graphql\lk\types\mutation\tariff;

use api\services\TariffService;
use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;

/**
 * Class TariffType
 *
 * @package api\graphql\lk\types\mutation\tariff
 */
class TariffType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'tariffBuy' => [
                'type' => $entityRegistry->accountTariff(),
                'args' => [
                    'price_id' => $typeRegistry->nonNull($typeRegistry->id()),
                ],
                'resolve' => function ($root, $args) {
                    return (new TariffService())->buyTariff($args['price_id']);
                }
            ],
        ];
    }
}
