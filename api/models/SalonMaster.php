<?php

namespace api\models;

use Yii;
use common\behaviors\AccountBehavior;
use api\queries\SalonMasterQuery;

/**
 * Class SalonMaster
 *
 * @package api\models
 */
class SalonMaster extends \common\models\SalonMaster
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
     * @param int $salonId
     * @param int $masterId
     * @return int
     */
    public static function deleteOne(int $salonId, int $masterId)
    {
        return self::deleteAll([
            'account_id' => Yii::$app->account->getId(),
            'salon_id' => $salonId,
            'master_id' => $masterId
        ]);
    }

    /**
     * @return SalonMasterQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SalonMasterQuery(get_called_class());
    }
}