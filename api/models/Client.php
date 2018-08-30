<?php

namespace api\models;

use api\buffers\BufferInterface;
use api\buffers\ClientBuffer;
use api\queries\ClientQuery;;

/**
 * Class Client
 * @package api\models
 */
class Client extends \common\models\Client implements BufferInterface
{
    /**
     * @var null
     */
    private static $buffer = null;

    /**
     * @return ClientQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ClientQuery(get_called_class());
    }

    /**
     * @return ClientBuffer|null
     */
    public static function buffer()
    {
        return self::$buffer ?? (self::$buffer = new ClientBuffer(self::find()));
    }
}