<?php

namespace common\models;

use common\queries\Query;

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
            [['user_id'], 'default', 'value' => 52],
            [['text'], 'string'],
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
}
