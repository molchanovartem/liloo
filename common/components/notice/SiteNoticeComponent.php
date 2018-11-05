<?php

namespace common\components\notice;

use Yii;
use common\models\Notice;

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
     * @param int $accountId
     * @param int $type
     * @param int $status
     * @param string $text
     * @param $data
     */
    function createNotice(int $accountId, int $type, int $status, string $text, $data)
    {
        $notice = $this->getNoticeModel();

        $notice->account_id = $accountId;
        $notice->type = $type;
        $notice->status = $status;
        $notice->text = $text;
        $notice->data = $this->currentModel($type, $data);

        $notice->save(false);
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
        return ($this->getNoticeModel())->where(['account_id' => Yii::$app->account->getId()])->all();
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
