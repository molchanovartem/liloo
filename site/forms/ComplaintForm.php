<?php

namespace site\forms;

use yii\base\Model;

/**
 * Class ComplaintForm
 * @package site\forms
 */
class ComplaintForm extends Model
{
    public $reason;
    public $recallId;

    const COMPLAINT_TYPE_LIE = 1;
    const COMPLAINT_TYPE_DIRT = 2;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['recallId', 'reason'], 'required'],
            [['reason'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function getComplaints()
    {
        return [
            self::COMPLAINT_TYPE_LIE => 'Ложь',
            self::COMPLAINT_TYPE_DIRT => 'Оскорбление',
        ];
    }

    /**
     * @return mixed
     */
    public function getComplaint()
    {
        return $this->getComplaints()[$this->reason];
    }
}
