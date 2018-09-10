<?php

namespace admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Class UserInteraction
 * @package admin\models
 */
class UserInteraction extends ActiveRecord
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return string
     */
    public static function tableName() {
        return '{{%admin_user_interaction}}';
    }

    /**
     * @return array
     */
    public function rules() {
        return [
            ['user_id', 'default', 'value' => Yii::$app->user->identity->id],
            [['comment'], 'required'],
            [['comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'comment' => 'Комментарий',
        ];
    }
}