<?php

namespace api\repositories;

use api\models\User;
use api\models\UserSchedule;

/**
 * Class UserRepository
 * @package api\repositories
 */
class UserRepository extends Repository
{
    protected static $instance = null;

    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findById(int $id)
    {
        return User::find()
            ->byId($id)
            ->one();
    }

    /**
     * @param int $userId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSchedule(int $userId, $startDate, $endDate)
    {
        /*
         * @todo
         * Реализовать выборку по датам
         */

        return UserSchedule::find()
            ->where(['user_id' => $userId])
            ->all();
    }
}