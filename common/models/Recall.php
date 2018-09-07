<?php

namespace common\models;

use common\behaviors\AccountBehavior;
use common\validators\AppointmentExistValidator;
use common\validators\UserExistValidator;
use Yii;

class Recall extends \yii\db\ActiveRecord
{
    const RECALL_TYPE_USER = 0;
    const RECALL_TYPE_MASTER_RESPONSE = 1;

    const ASSESSMENT_LIKE = 1;
    const ASSESSMENT_DEFAULT = 0;
    const ASSESSMENT_DISLIKE = -1;

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
            [['account_id', 'user_id', 'appointment_id', 'type'], 'required'],
            [['account_id', 'user_id', 'appointment_id', 'type', 'parent_id', 'assessment'], 'integer'],
            [['assessment'], 'default', 'value' => 0],
            [['text'], 'string'],
            [['create_time'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['assessment', 'in', 'range' => $this->getAssessments()],
            ['user_id', UserExistValidator::class],
            ['appointment_id', AppointmentExistValidator::class],
        ];
    }
    public function behaviors(): array
    {
        return [
            AccountBehavior::class
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
