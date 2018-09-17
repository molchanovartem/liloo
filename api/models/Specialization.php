<?php

namespace api\models;

use api\queries\SpecializationQuery;

/**
 * Class Specialization
 * @package api\models
 */
class Specialization extends \common\models\Specialization
{
    /**
     * @return SpecializationQuery|\common\queries\SpecializationQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SpecializationQuery(get_called_class());
    }
}