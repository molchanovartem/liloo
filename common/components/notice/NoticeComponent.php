<?php

namespace common\components\notice;

use common\components\notice\types\NoticeType;
use common\components\notice\types\UserRegistrationType;
use yii\base\BaseObject;

/**
 * Class NoticeComponent
 *
 * @package common\components\notice
 */
class NoticeComponent extends BaseObject
{
    public function createUserRegistration($userId, $text, $date)
    {
        return $this->create(new UserRegistrationType([
            'user_id' => $userId,
            'text' => $text,
            'date' => $date
        ]));
    }

    /**
     * @param $type NoticeType
     * @return mixed
     */
    protected function create($type)
    {
        if (!$type->validate()) {
            // throw new Error
        }

        return $type->save(false);
    }
}