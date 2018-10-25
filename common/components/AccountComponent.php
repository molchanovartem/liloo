<?php

namespace common\components;

use Yii;
use yii\base\BaseObject;
use common\models\AccountTariff;

/**
 * Class AccountComponent
 *
 * @package common\components
 */
class AccountComponent extends BaseObject
{
    /**
     * @return mixed
     * @throws \Throwable
     */
    public function getId()
    {
        $identity = Yii::$app->user->getIdentity();

        return $identity->getAccountId();
    }

    public function getBalance()
    {
        return 1750.00;
    }

    /**
     * @return array
     */
    public function getTariffs(): array
    {
        return (Yii::$app->cache)->getOrSet('accountTariffs', function () {
            return AccountTariff::find()->all(); // @todo allByAccountId
        });
    }
}