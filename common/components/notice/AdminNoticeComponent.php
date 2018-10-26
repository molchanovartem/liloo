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
    public function getNotice()
    {
        return new AdminNotice();
    }

    /**
     * @param int $id
     * @return mixed|void
     * @throws \Exception
     */
    public function checkNotice(int $id)
    {
        $data = $this->findNotice($id);
        $data->status = AdminNotice::STATUS_READ
            ? $data->status = AdminNotice::STATUS_UNREAD
            : $data->status = AdminNotice::STATUS_READ;

        $data->save();
    }
}
