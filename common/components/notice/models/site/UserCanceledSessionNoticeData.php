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
    public $endDate;
    public $clientId;
    public $masterId;

}
