<?php

namespace api\models;

use Yii;
use api\queries\MasterScheduleQuery;
use common\behaviors\AccountBehavior;

/**
 * Class MasterSchedule
 *
 * @package api\models
 */
class MasterSchedule extends \common\models\MasterSchedule
{
    /**
     * @return MasterScheduleQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MasterScheduleQuery(get_called_class());
    }
}