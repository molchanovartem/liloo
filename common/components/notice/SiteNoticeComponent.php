<?php

namespace common\components\notice;

use common\models\Notice;
use Yii;

/**
 * Class SiteNoticeComponent
 * @package common\components\notice
 */
class SiteNoticeComponent extends BaseNoticeComponent
{
    /**
     * @return Notice
     */
    function getNoticeModel()
    {
        return new Notice();
    }

    /**
     * @param int $id
     * @return mixed|void
     * @throws \Exception
     */
    public function checkNotice(int $id)
    {
        $data = $this->findNotice($id);
        $data->status = Notice::STATUS_READ
            ? $data->status = Notice::STATUS_UNREAD
            : $data->status = Notice::STATUS_READ;

        $data->save();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getUserNotice()
    {
        return Notice::find()->where(['account_id' => Yii::$app->account->getId()])->all();
    }

    /**
     * @param $type
     * @param $model
     * @return mixed
     */
    public function getNoticeDataMethods($type, $model)
    {
        switch ($type) {
            case Notice::TYPE_USER_CANCELED_SESSION:
                return call_user_func([$this, 'createUserCanceledSessionNoticeData'], $model);
            case Notice::TYPE_USER_RECALL:
                return call_user_func([$this, 'convertModelToUserRegistrationModel'], $model);
        }
    }
}
