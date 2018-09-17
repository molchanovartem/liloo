<?php

namespace api\models;

use api\queries\SalonServiceQuery;

/**
 * Class SalonService
 *
 * @package api\models
 */
class SalonService extends \common\models\SalonService
{
    /**
     * @return SalonServiceQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SalonServiceQuery(get_called_class());
    }
}