<?php

namespace common\models;

use Yii;
use common\behaviors\AccountBehavior;
use common\queries\SalonMasterQuery;

class SalonMaster extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%salon_master}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'salon_id', 'master_id'], 'required'],
            [['account_id', 'salon_id', 'master_id'], 'integer']
        ];
    }
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
     * @return SalonMasterQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SalonMasterQuery(get_called_class());
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