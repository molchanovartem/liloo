<?php

namespace api\models;

use api\queries\MasterSpecializationQuery;

/**
 * Class MasterSpecialization
 *
 * @package api\models
 */
class MasterSpecialization extends \common\models\MasterSpecialization
{
    /**
     * @return MasterSpecializationQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MasterSpecializationQuery(get_called_class());
    }
}