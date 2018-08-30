<?php

namespace api\models;

use api\buffers\BufferInterface;
use api\buffers\ServiceBuffer;
use api\queries\ServiceQuery;

/**
 * Class Service
 *
 * @package api\models
 */
class Service extends \common\models\Service implements BufferInterface
{
    /**
     * @var null
     */
    private static $buffer = null;

    /**
     * @return ServiceQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ServiceQuery(get_called_class());
    }

    /**
     * @return ServiceBuffer|null
     */
    public static function buffer()
    {
        return self::$buffer ?? (self::$buffer = new ServiceBuffer(get_called_class()));
    }


}