<?php

namespace common\components;

use common\models\Notice;
use yii\base\Component;

/**
 * Class NoticeComponent
 * @package common\components
 */
class NoticeComponent extends Component
{
    /**
     * @param int $accountId
     * @param int $type
     * @param int $status
     * @param $text
     * @param $data
     */
    public function createNotice(int $accountId,int $type, int $status, $text, $data)
    {
        $notice = new Notice();

        $notice->account_id = $accountId;
        $notice->type = $type;
        $notice->status = $status;
        $notice->text = $text;
        $notice->data = $data;

        $notice->save(false);
    }
}
