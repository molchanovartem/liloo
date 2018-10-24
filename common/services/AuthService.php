<?php

namespace common\services;

use Yii;
use admin\models\AdminNotice;
use common\core\service\ModelService;

/**
 * Class AuthService
 * @package common\services
 */
class AuthService extends ModelService
{
    const EVENT_USER_REGISTRATION = 'registration';

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_USER_REGISTRATION, function ($model) {
            //TODO тут отправка смс с паролем
            Yii::$app->adminNotice->createNotice(AdminNotice::TYPE_USER_REGISTRATION, AdminNotice::STATUS_UNREAD, 'text', $model->sender);
        });
    }
}
