<?php

namespace api\models;

use common\behaviors\AccountBehavior;
use api\queries\MasterSpecializationQuery;

/**
 * Class MasterSpecialization
 *
 * @package api\models
 */
class MasterSpecialization extends \common\models\MasterSpecialization
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            AccountBehavior::class
        ];
    }

    /**
     * @return MasterSpecializationQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MasterSpecializationQuery(get_called_class());
    }
}