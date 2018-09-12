<?php

namespace api\schema\type\mutation\tariff;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;

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
                    'attributes' => $typeRegistry->nonNull($inputRegistry->recallCreate())
                ],
                'resolve' => function ($root, $args) {
                    return (new RecallService())->create($args['attributes'], Recall::RECALL_TYPE_USER, Recall::SCENARIO_DEFAULT);
                }
            ],
        ];
    }
}