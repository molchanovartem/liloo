<?php

namespace api\graphql\lk\types\entity;

use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\lk\AccountTariff;

/**
 * Class AccountTariffType
 *
 * @package api\graphql\lk\types\entity
 */
class AccountTariffType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'accountTariffs' => [
                'type' => $typeRegistry->listOff($entityRegistry->accountTariff()),
                'description' => 'Коллекция цен тарифов',
                'resolve' => function ($root, $args) {
                    return AccountTariff::find()->allByCurrentAccountId();
                }
            ],
        ];
    }
}