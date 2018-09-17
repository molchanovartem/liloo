<?php

namespace api\models;

use api\queries\MasterQuery;

/**
 * Class Master
 *
 * @package api\models
 */
class Master extends \common\models\Master
{
    /**
     * @return MasterQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MasterQuery(get_called_class());
    }
}