<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Notice
 * @package common\models
 */
class Notice extends ActiveRecord
{
    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    const TYPE_USER_CANCELED_SESSION = 1;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%notice}}';
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
    public function getTypeList()
    {
        return [
            self::TYPE_USER_CANCELED_SESSION => 'Клиент отменил сеанс',
        ];
    }

    /**
     * @return string
     */
    public function getTypeName() : string
    {
        return $this->getTypeList()[$this->type];
    }

    /**
     * @return array
     */
    public function getStatusList()
    {
        return [
            self::STATUS_UNREAD => 'Не прочитано',
            self::STATUS_READ => 'Прочитано',
        ];
    }

    /**
     * @return string
     */
    public function getStatusName() : string
    {
        return $this->getStatusList()[$this->status];
    }
}
