<?php

namespace api\models;

use api\queries\SalonQuery;

/**
 * Class Salon
 *
 * @package api\models
 */
class Salon extends \common\models\Salon
{
    public static function find()
    {
        return new SalonQuery(get_called_class());
    }
}