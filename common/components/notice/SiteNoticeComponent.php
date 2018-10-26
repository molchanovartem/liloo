<?php

namespace common\components\notice;

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
    function getNotice()
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
}
