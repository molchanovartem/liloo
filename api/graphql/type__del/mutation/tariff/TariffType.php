<?php

namespace api\schema\type\mutation\tariff;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\TariffService;

/**
 * Class TariffType
 * @package api\schema\type\mutation\tariff
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
