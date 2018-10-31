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
    public $login;
    public $phone;
    public $password;
    public $type;
    public $verifyCode;
    public $deal;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['login', 'phone', 'password', 'type', 'deal'], 'required'],
            ['verifyCode', 'captcha', 'captchaAction' => '/auth/captcha'],
            ['phone', 'unique'],
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
            'deal'     => '',
        ];
    }

    public function beforeValidate()
    {
        $this->login = Yii::$app->security->generateRandomString(10);
        //$this->password = Yii::$app->security->generatePasswordHash(rand(900000, 9999999));
        $this->password = Yii::$app->security->generatePasswordHash('123');

        return parent::beforeValidate();
    }
}
