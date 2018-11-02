<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;
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
                'args' => [
                    'limit' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30,
                    ],
                    'offset' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 0,
                    ],
                ],
                'resolve' => function ($root, $args) {
                    return AccountTariff::find()
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->allByCurrentAccountId();
                }
            ],
            'accountTariffsTotalCount' => [
                'type' => $typeRegistry->int(),
                'resolve' => function ($root, $args) {
                    return AccountTariff::find()->countByCurrentAccountId();
                }
            ],
        ];
    }
}
