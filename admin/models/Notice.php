<?php

namespace admin\models;

use yii\db\ActiveRecord;

class Notice extends ActiveRecord
{
    const STATUS_NEW_USER = 0;
    const STATUS_PROCESSED_USER = 1;

    const TYPE_USER_REGISTRATION = 0;
//    const TYPE_USER_REGISTRATION = 1;
//    const TYPE_USER_REGISTRATION = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_notice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'text', 'data'], 'required'],
//            [['text'], 'string', 'max' => 255],
        ];
    }

    public function getNotices()
    {
        return [
            self::NEW_USER => 'Новый пользователь',
        ];
    }

    public function getNotice($notice)
    {
        return $this->getNotices()[$notice];
    }

    public function getStatuses()
    {
        return [
            self::NEW_USER => 'Новый пользователь',
        ];
    }

    public function getStatus($status)
    {
        return $this->getStatuses()[$status];
    }
}