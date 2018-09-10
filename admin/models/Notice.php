<?php

namespace admin\models;

use yii\db\ActiveRecord;

class Notice extends ActiveRecord
{
    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    const TYPE_USER_REGISTRATION = 0;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%admin_notice}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['type', 'status', 'text', 'data'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return [
            self::TYPE_USER_REGISTRATION => 'Регистрация',
        ];
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getType($type)
    {
        return $this->getTypes()[$type];
    }

    /**
     * @return array
     */
    public function getStatuses()
    {
        return [
            self::STATUS_UNREAD => 'Не прочитано',
            self::STATUS_READ => 'Прочитано',
        ];
    }

    /**
     * @param $status
     * @return mixed
     */
    public function getStatus($status)
    {
        return $this->getStatuses()[$status];
    }
}