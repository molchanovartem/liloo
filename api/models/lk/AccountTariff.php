<?php

namespace api\models\lk;

use common\behaviors\AccountBehavior;

/**
 * Class AccountTariff
 *
 * @package api\models\lk
 */
class AccountTariff extends \common\models\AccountTariff
{
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