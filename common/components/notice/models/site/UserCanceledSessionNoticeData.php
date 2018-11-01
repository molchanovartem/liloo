<?php

namespace common\components\notice\models\site;

use yii\base\Model;

/**
 * Class UserCanceledSessionNoticeData
 * @package common\components\notice\model\site
 */
class UserCanceledSessionNoticeData extends Model
{
    public $appointmentId;
    public $startDate;
    public $clientId;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['appointmentId', 'startDate', 'clientId',], 'required'],
            [['appointmentId', 'clientId'], 'integer'],
            [['start_date',], 'date', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }
}
