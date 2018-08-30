<?php

namespace api\models;

use api\queries\ConvenienceQuery;

/**
 * Class Convenience
 *
 * @package api\models
 */
class Convenience extends \common\models\Convenience
{
    /**
     * @return ConvenienceQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ConvenienceQuery(get_called_class());
    }
}