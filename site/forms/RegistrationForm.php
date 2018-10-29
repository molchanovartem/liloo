<?php

namespace site\forms;

use Yii;
use yii\base\Model;

/**
 * Class RegistrationForm
 * @package site\models
 */
class RegistrationForm extends Model
{
    public $phone;
    public $type;
    public $verifyCode;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['phone', 'type'], 'required'],
            ['verifyCode', 'captcha', 'captchaAction' => '/auth/captcha'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'phone'    => 'Телефон',
            'password' => 'Пароль',
            'type'     => 'Тип',
        ];
    }
}
