<?php

namespace app\components\balance;


use app\models\storehouse\Storehouse;
use Yii;
use app\models\user\User;

/**
 * This is the model class for table "{{%journal_balance}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $storehouse_id
 * @property integer $type
 * @property integer $type_operation
 * @property string $sum
 * @property string $reason
 * @property string $data_time
 *
 */
class JournalBalanceModel extends \yii\db\ActiveRecord
{
    const TYPE_SERVICE = 1;
    const TYPE_USER = 2;
    const TYPE_STOREHOUSE = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%journal_balance}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'type_operation'], 'required'],
            [['user_id', 'storehouse_id', 'type', 'type_operation'], 'integer'],
            [['sum'], 'number'],
            [['date_time'], 'safe'],
            [['reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'storehouse_id' => Yii::t('app', 'Storehouse ID'),
            'type' => Yii::t('app', 'Type'),
            'type_operation' => Yii::t('app', 'Type Operation'),
            'sum' => Yii::t('app', 'Sum'),
            'reason' => Yii::t('app', 'Reason'),
            'date_time' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getStorehouse()
    {
        return $this->hasOne(Storehouse::className(), ['id' => 'storehouse_id']);
    }
}
