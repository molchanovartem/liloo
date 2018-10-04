<?php

namespace api\models\lk;

use common\behaviors\AccountBehavior;

/**
 * Class MasterSpecialization
 *
 * @package api\models\lk
 */
class MasterSpecialization extends \common\models\MasterSpecialization
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