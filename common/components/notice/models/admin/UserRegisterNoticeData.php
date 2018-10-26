<?php

namespace common\components\notice\models\admin;

use yii\base\Model;

class UserRegisterNoticeData extends Model
{
    public $userId;
    public $phone;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['userId', 'phone',], 'required'],
            [['userId'], 'integer'],
        ];
    }
}
