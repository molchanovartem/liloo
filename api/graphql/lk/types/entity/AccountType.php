<?php

namespace api\graphql\lk\types\entity;

use Yii;
use common\models\Account;
use api\models\lk\AccountTariff;
use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;

/**
 * Class AccountType
 *
 * @package api\graphql\lk\types\entity
 */
class AccountType extends \api\graphql\base\types\entity\AccountType implements QueryTypeInterface
{
    public function fields(): array
    {
        return array_merge(parent::fields(), [
            'tariffs' => [
                'type' => $this->typeRegistry->listOff($this->entityRegistry->accountTariff()),
                'resolve' => function ($root) {
                    return AccountTariff::find()->allByCurrentAccountId();
                }
            ]
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