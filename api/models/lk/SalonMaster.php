<?php

namespace api\models\lk;

use Yii;
use common\behaviors\AccountBehavior;

/**
 * Class SalonMaster
 *
 * @package api\models\lk
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
}