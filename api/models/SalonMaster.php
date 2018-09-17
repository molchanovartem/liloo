<?php

namespace api\models;

use api\queries\SalonMasterQuery;

/**
 * Class SalonMaster
 *
 * @package api\models
 */
class SalonMaster extends \common\models\SalonMaster
{
    /**
     * @return SalonMasterQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SalonMasterQuery(get_called_class());
    }
}