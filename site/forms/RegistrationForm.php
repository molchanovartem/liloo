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

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['login', 'phone', 'password', 'type'], 'required'],
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

    public function beforeValidate()
    {
        $this->login = Yii::$app->security->generateRandomString(10);
        //$this->password = Yii::$app->security->generatePasswordHash(rand(900000, 9999999));
        $this->password = Yii::$app->security->generatePasswordHash('123');

        return parent::beforeValidate();
    }
}
