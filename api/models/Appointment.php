<?php

namespace api\models;

use api\queries\AppointmentQuery;

/**
 * Class Appointment
 * @package api\models
 */
class Appointment extends \common\models\Appointment
{
    /**
     * @return AppointmentQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new AppointmentQuery(get_called_class());
    }
}