<?php

namespace api\models\lk;

use Yii;
use common\behaviors\UserId;
use api\validators\AppointmentExistValidator;


/**
 * Class Recall
 *
 * @package api\models\lk
 */
class Recall extends \common\models\Recall
{
    const SCENARIO_ANSWER = 'answer';

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
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['status', 'default', 'value' => self::STATUS_NOT_VERIFIED],
            ['assessment', 'in', 'range' => $this->getAssessments(), 'on' => self::SCENARIO_DEFAULT],
            ['appointment_id', AppointmentExistValidator::class, 'on' => self::SCENARIO_DEFAULT],
            ['parent_id', 'validateParent', 'on' => self::SCENARIO_ANSWER],
            ['parent_id', 'unique', 'on' => self::SCENARIO_ANSWER],
        ]);
    }

    /**
     * @param $attribute
     */
    public function validateParent($attribute)
    {
        $recall = self::find()
            ->byId($this->$attribute)
            ->allByCurrentAccountId();

        if (empty($recall)) {
            $this->addError($attribute, 'Невозможно добавить ответ');
        }
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
