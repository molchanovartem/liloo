<?php

namespace api\models;

use common\behaviors\AccountBehavior;
use api\queries\AccountTariffQuery;

/**
 * Class AccountTariff
 * @package api\models
 */
class AccountTariff extends \common\models\AccountTariff
{
    /**
     * @return AccountTariffQuery|\common\queries\Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new AccountTariffQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            AccountBehavior::class
        ];
    }

}