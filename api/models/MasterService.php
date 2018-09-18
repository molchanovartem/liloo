<?php

namespace api\models;

use common\behaviors\AccountBehavior;
use api\queries\MasterServiceQuery;

/**
 * Class MasterService
 *
 * @package api\models
 */
class MasterService extends \common\models\MasterService
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
     * @return MasterServiceQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MasterServiceQuery(get_called_class());
    }
}