<?php

namespace admin\models;


use yii\db\ActiveRecord;

class UserInteraction extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%admin_user_interaction}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'comment',], 'required'],
            [['comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'comment' => 'Комментарий',
        ];
    }
}