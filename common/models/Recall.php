<?php

namespace common\models;

use common\behaviors\AccountBehavior;
use Yii;

class Recall extends \yii\db\ActiveRecord
{
    const RECALL_TYPE_USER = 0;
    const RECALL_TYPE_MASTER_RESPONSE = 0;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%recall}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'author_id', 'appointment_id', 'type'], 'required'],
            [['account_id', 'author_id', 'appointment_id', 'type', 'parent_id', 'assessment'], 'integer'],
            [['text'], 'string'],
            [['create_time'], 'date', 'format' => 'php:Y-m-d H:i:s'],
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
