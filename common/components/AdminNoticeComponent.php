<?php

namespace common\components;

use admin\models\Notice;
use yii\base\Component;

/**
 * Class AdminNoticeComponent
 * @package admin\components
 */
class AdminNoticeComponent extends Component
{
    /**
     * @param int $type
     * @param int $status
     * @param $text
     * @param $data
     */
    public function createNotice(int $type, int $status, $text, $data)
    {
        $notice = new Notice();

        $notice->type = $type;
        $notice->status = $status;
        $notice->text = $text;
        $notice->data = $data;

        $notice->save(false);
    }
}