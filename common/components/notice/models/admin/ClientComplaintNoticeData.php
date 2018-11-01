<?php

namespace common\components\notice\models\admin;

use yii\base\Model;

/**
 * Class ClientComplaintNoticeData
 * @package common\components\notice\models\admin
 */
class ClientComplaintNoticeData extends Model
{
    public $recallId;
    public $text;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['recallId', 'text',], 'required'],
            [['recallId'], 'integer'],
            [['text'], 'string'],
        ];
    }
}
