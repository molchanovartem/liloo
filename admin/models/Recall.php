<?php

namespace admin\models;

/**
 * Class Recall
 * @package admin\models
 */
class Recall extends \common\models\Recall
{
    /**
     * @return array
     */
    public function getStatuses()
    {
        return [
            self::STATUS_NOT_VERIFIED => 'Не проверено',
            self::STATUS_VERIFIED => 'Проверено',
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

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'appointment_id' => 'ID сеанса',
            'text' => 'Текст',
            'assessment' => 'Оценка',
            'status' => 'Статус',
            'type' => 'Тип',
        ];
    }
}