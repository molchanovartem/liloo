<?php

namespace common\components\notice\types;

/**
 * Class UserRegistrationType
 *
 * @package common\components\notice\types
 */
class UserRegistrationType extends NoticeType
{
    private $userId = null;
    private $date = null;

    /**
     * @param null $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param null $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function beforeSave($insert)
    {
        $this->data = json_encode([
            'user_id' => $this->userId,
            'date' => $this->date
        ]);

        return parent::beforeSave($insert);
    }
}