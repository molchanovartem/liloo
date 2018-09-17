<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\AccountTariff;
use api\models\Tariff;

/**
 * Class AccountTariffType
 *
 * @package api\graphql\lk\types\entity
 */
class AccountTariffType extends ObjectType implements QueryTypeInterface
{
    /**
     * TariffType constructor.
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'tariff_id' => $typeRegistry->id(),
                    'account_id' => $typeRegistry->id(),
                    'start_date' => $typeRegistry->string(),
                    'end_date' => $typeRegistry->string(),
                    'tariff' => [
                        'type' => $entityRegistry->tariff(),
                        'resolve' => function (AccountTariff $accountTariff, $args, $context, $info) {
                            return Tariff::find()->oneById($accountTariff->tariff_id);
                        }
                    ],
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
            'accountTariffs' => [
                'type' => $typeRegistry->listOff($entityRegistry->accountTariff()),
                'description' => 'Коллекция цен тарифов',
                'resolve' => function ($root, $args) {
                    return AccountTariff::find()->allByAccountId();
                }
            ],
        ];
    }
}