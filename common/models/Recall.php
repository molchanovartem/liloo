<?php

namespace common\models;

use common\behaviors\UserId;
use common\queries\RecallQuery;
use common\validators\AppointmentExistValidator;
use Yii;

/**
 * Class Recall
 *
 * @package common\models
 */
class Recall extends \yii\db\ActiveRecord
{
    const RECALL_TYPE_USER = 0;
    const RECALL_TYPE_MASTER_RESPONSE = 1;

    const ASSESSMENT_LIKE = 1;
    const ASSESSMENT_DEFAULT = 0;
    const ASSESSMENT_DISLIKE = -1;

    const SCENARIO_ANSWER = 'answer';

    const STATUS_NOT_VERIFIED = 0;
    const STATUS_VERIFIED = 1;

    /**
     * @return array
     */
    public function scenarios()
    {
        $defaultAttributes = ['account_id', 'user_id', 'appointment_id', 'type', 'parent_id', 'assessment', 'text', 'status'];

        return [
            self::SCENARIO_DEFAULT => $defaultAttributes,
            self::SCENARIO_ANSWER => $defaultAttributes
        ];
    }

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
            ['status', 'default', 'value' => self::STATUS_NOT_VERIFIED],
            [['user_id'], 'default', 'value' => 52],
            [['text'], 'string'],
            ['assessment', 'in', 'range' => $this->getAssessments(), 'on' => self::SCENARIO_DEFAULT],
            ['appointment_id', AppointmentExistValidator::class],
            ['parent_id', 'validateParent', 'on' => self::SCENARIO_ANSWER],
            ['parent_id', 'unique', 'on' => self::SCENARIO_ANSWER],
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
     * @param $attribute
     */
    public function validateParent($attribute)
    {
        $recall = Recall::find()
            ->byId($this->$attribute)
            ->allByAccountId();

        if (empty($recall)) {
            $this->addError($attribute, 'Невозможно добавить ответ');
        }
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

    /**
     * @return RecallQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new RecallQuery(get_called_class());
}
}
