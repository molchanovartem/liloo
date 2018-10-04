<?php

namespace api\models\lk;

use common\behaviors\AccountBehavior;

/**
 * Class MasterService
 *
 * @package api\models\lk
 */
class MasterService extends \common\models\MasterService
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