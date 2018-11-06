<?php

namespace common\components\notice;

use admin\models\AdminNotice;

/**
 * Class AdminNoticeComponent
 * @package common\components\notice
 */
class AdminNoticeComponent extends BaseNoticeComponent
{
    /**
     * @return AdminNotice
     */
    public function getNoticeModel()
    {
        return new AdminNotice();
    }

    /**
     * @param int $type
     * @param int $status
     * @param string $text
     * @param $data
     */
    function createNotice(int $type, int $status, string $text, $data)
    {
        $notice = $this->getNoticeModel();

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
        $data->status == AdminNotice::STATUS_READ
            ? $data->status = AdminNotice::STATUS_UNREAD
            : $data->status = AdminNotice::STATUS_READ;

        $data->save();
    }

    /**
     * @return AdminNotice[]
     */
    public function getAllNotice()
    {
        return AdminNotice::find()->all();
    }

    /**
     * @param $type
     * @param $model
     * @return mixed
     */
    public function getNoticeDataMethods($type, $model)
    {
        switch ($type) {
            case AdminNotice::TYPE_USER_REGISTRATION:
                return call_user_func([$this, 'createUserRegisterNoticeData'], $model);
            case AdminNotice::TYPE_CLIENT_COMPLAINT:
                return call_user_func([$this, 'createClientComplaintNoticeData'], $model);
        }
    }
}
