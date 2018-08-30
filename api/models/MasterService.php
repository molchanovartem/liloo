<?php

namespace api\models;

use api\queries\MasterServiceQuery;
use common\behaviors\AccountBehavior;

/**
 * Class MasterService
 *
 * @package api\models
 */
class MasterService extends \common\models\MasterService
{
    /**
     * @return MasterServiceQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MasterServiceQuery(get_called_class());
    }
}