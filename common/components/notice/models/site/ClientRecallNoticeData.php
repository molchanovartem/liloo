<?php

namespace common\components\notice\models\site;

use yii\base\Model;

/**
 * Class ClientRecallNoticeData
 * @package common\components\notice\models\site\
 */
class ClientRecallNoticeData extends Model
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
