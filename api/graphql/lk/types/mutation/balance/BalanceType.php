<?php

namespace api\graphql\lk\types\mutation\balance;

use Yii;
use common\models\BalanceJournal;
use api\graphql\MutationFieldsTypeInterface;
use api\graphql\TypeRegistry;

/**
 * Class BalanceType
 *
 * @package api\graphql\lk\types\mutation\account
 */
class BalanceType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        return [
            'balanceIncrease' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'sum' => $typeRegistry->decimal()
                ],
                'resolve' => function ($root, $args) {
                    return (bool)Yii::$app->balance->increase(Yii::$app->account->getId(), $args['sum'], BalanceJournal::TYPE_REASON_INCREASE_BALANCE, null);
                }
            ]
        ];
    }
}