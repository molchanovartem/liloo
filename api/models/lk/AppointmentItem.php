<?php

namespace api\models\lk;

use api\graphql\core\BufferInterface;
use api\graphql\lk\buffers\AppointmentItemBuffer;

/**
 * Class AppointmentItem
 *
 * @package api\models\lk
 */
class AppointmentItem extends \common\models\AppointmentItem implements BufferInterface
{
    private static $buffer = null;

    /*
         * @todo
         * service_id
         * service_duration количество символов
         */


    /**
     * @return AppointmentItemBuffer|null
     */
    public static function buffer()
    {
        return self::$buffer ?? (self::$buffer = new AppointmentItemBuffer(self::find()));
    }
}