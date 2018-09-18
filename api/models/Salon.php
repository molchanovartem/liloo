<?php

namespace api\models;

use Yii;
use common\behaviors\AccountBehavior;
use common\behaviors\UserId;
use api\queries\SalonQuery;

/**
 * Class Salon
 *
 * @package api\models
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
     * @return SalonQuery|\common\queries\Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SalonQuery(get_called_class());
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
