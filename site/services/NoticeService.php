<?php

namespace site\services;

use Yii;
use common\core\service\ModelService;
use common\models\Notice;

/**
 * Class NoticeService
 * @package site\services
 */
class NoticeService extends ModelService
{
    public function getNotices()
    {
        $this->setData(['notices' => Notice::find()->where(['account_id' => Yii::$app->account->getId()])->all()]);
    }
}