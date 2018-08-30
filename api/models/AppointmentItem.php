<?php

namespace api\models;

use api\buffers\AppointmentItemBuffer;
use api\buffers\BufferInterface;
use api\queries\AppointmentItemQuery;

/**
 * Class AppointmentService
 * @package api\models
 */
class AppointmentItem extends \common\models\AppointmentItem implements BufferInterface
{
    private static $buffer = null;

    public static function find()
    {
        return new AppointmentItemQuery(get_called_class());
    }

    public static function buffer()
    {
        return self::$buffer ?? (self::$buffer = new AppointmentItemBuffer(self::find()));
    }
}