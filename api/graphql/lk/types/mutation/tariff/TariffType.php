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
        $inputRegistry = $typeRegistry->getMutationInputRegistry();

        return [
            'tariffBuy' => [
                'type' => $entityRegistry->accountTariff(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputRegistry->accountTariffCreate())
                ],
                'resolve' => function ($root, $args) {
                    return (new TariffService())->buyTariff($args['attributes']);
                }
            ],
        ];
    }
}
