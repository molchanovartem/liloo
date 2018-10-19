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
}
