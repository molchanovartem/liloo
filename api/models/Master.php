<?php

namespace api\models;

use Yii;
use api\queries\MasterQuery;
use common\behaviors\AccountBehavior;

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