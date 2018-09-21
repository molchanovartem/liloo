<?php

namespace api\graphql\lk\types\entity;

use Yii;
use GraphQL\Type\Definition\ObjectType;
use api\models\AccountTariff;
use api\graphql\TypeRegistry;
use api\models\Account;
use api\graphql\QueryTypeInterface;

/**
 * Class AccountType
 *
 * @package api\graphql\lk\types\entity
 */
class AccountType extends ObjectType implements QueryTypeInterface
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'balance' => $typeRegistry->decimal(),
                    'tariffs' => [
                        'type' => $typeRegistry->listOff($entityRegistry->accountTariff()),
                        'resolve' => function ($root) {
                            return AccountTariff::find()->allByCurrentAccountId();
                        }
                    ]
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
            'account' =>[
                'type' => $entityRegistry->account(),
                'resolve' => function ($root) {
                    return Account::find()->oneById(Yii::$app->account->getId());
                }
            ]
        ];
    }

}