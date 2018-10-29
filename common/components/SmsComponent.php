<?php

namespace common\components;

use yii\base\BaseObject;

/**
 * Class SmsComponent
 *
 * @package common\components
 */
class SmsComponent extends BaseObject
{
    /**
     * @param string $text
     */
    public function send($phone, $text = '')
    {
        file_put_contents(dirname(dirname(__DIR__)) .DIRECTORY_SEPARATOR . 'temp/smsMessages.txt', $text);
    }
}