<?php

namespace api\modules\v1\models;

use api\modules\v1\queries\SalonQuery;

/**
 * Class SalonUser
 * @package api\modules\v1\models
 */
class SalonUser extends \common\models\SalonUser
{
    /**
     * @return SalonQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SalonQuery(get_called_class());
    }
}