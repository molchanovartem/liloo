<?php

namespace api\models\lk;

use common\behaviors\AccountBehavior;
use common\behaviors\UserId;

/**
 * Class Appointment
 *
 * @package api\models\lk
 */
class Appointment extends \common\models\Appointment
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            UserId::class,
            AccountBehavior::class
        ];
    }
}