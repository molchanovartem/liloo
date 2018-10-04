<?php

namespace api\models\lk;

use Yii;
use common\behaviors\AccountBehavior;
use common\behaviors\UserId;

/**
 * Class Salon
 *
 * @package api\models\lk
 */
class Salon extends \common\models\Salon
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            UserId::class,
            AccountBehavior::class,
        ];
    }

    /**
     * @param int $id
     * @return int
     */
    public static function deleteById(int $id)
    {
        return self::deleteAll([
            'id' => $id,
            'account_id' => Yii::$app->account->getId()
        ]);
    }

}
