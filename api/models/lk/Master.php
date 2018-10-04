<?php

namespace api\models\lk;

use Yii;
use common\behaviors\AccountBehavior;

/**
 * Class Master
 *
 * @package api\models
 */
class Master extends \common\models\Master
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            AccountBehavior::class
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