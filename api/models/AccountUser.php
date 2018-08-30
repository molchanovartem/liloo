<?php

namespace api\models;

use Yii;
use common\behaviors\AccountBehavior;
use api\queries\AccountUserQuery;

/**
 * Class AccountUser
 *
 * @package api\models
 */
class AccountUser extends \common\models\AccountUser
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            AccountBehavior::class
        ]);
    }

    /**
     * @param int $userId
     * @return int
     */
    public static function deleteOneClient(int $userId)
    {
        return self::deleteByUserId($userId, User::TYPE_CLIENT);
    }

    /**
     * @param int $userId
     * @return int
     */
    public static function deleteOneMaster(int $userId)
    {
        return self::deleteByUserId($userId, User::TYPE_MASTER);
    }

    /**
     * @param int $userId
     * @param $userType
     * @return int
     */
    public static function deleteByUserId(int $userId, $userType)
    {
        return self::deleteAll([
            'user_id' => $userId,
            'user_type' => $userType,
            'account_id' => Yii::$app->account->getId()
        ]);
    }

    public static function find()
    {
        return new AccountUserQuery(get_called_class());
    }
}