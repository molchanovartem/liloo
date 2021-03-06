<?php

namespace common\models;

use common\behaviors\UserId;
use common\queries\Query;

/**
 * Class Recall
 *
 * @package common\models
 */
class Recall extends \yii\db\ActiveRecord
{
    const RECALL_TYPE_USER = 1;
    const RECALL_TYPE_MASTER_RESPONSE = 2;

    const ASSESSMENT_LIKE = 1;
    const ASSESSMENT_DEFAULT = 0;
    const ASSESSMENT_DISLIKE = -1;

    const STATUS_NOT_VERIFIED = 0;
    const STATUS_VERIFIED = 1;

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
            [['text'], 'required'],
            [['account_id', 'user_id', 'appointment_id', 'type', 'parent_id', 'assessment'], 'integer'],
            [['assessment'], 'in', 'range' => $this->getAssessments()],
            [['text'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            UserId::class,
        ];
    }

    /**
     * @return array
     */
    public function getAssessments()
    {
        return [
            self::ASSESSMENT_LIKE,
            self::ASSESSMENT_DEFAULT,
            self::ASSESSMENT_DISLIKE,
        ];
    }

    /**
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointment()
    {
        return $this->hasOne(Appointment::class, ['id' => 'appointment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Recall::class, ['id' => 'parent_id']);
    }
}
