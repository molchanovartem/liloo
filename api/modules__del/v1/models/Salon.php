<?php

namespace api\modules\v1\models;

use api\modules\v1\queries\SalonQuery;

/**
 * Class Salon
 * @package api\modules\v1\models
 */
class Salon extends \common\models\Salon
{
    /**
     * @return SalonQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SalonQuery(get_called_class());
    }
}