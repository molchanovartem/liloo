<?php

namespace site\forms;

use site\models\User;
use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 *
 * @package site\forms
 */
class LoginForm extends Model
{
    public $phone;
    public $password;
    public $verifyCode;
    private $_user = false;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['phone', 'password'], 'required'],
            [['phone'], 'string'],
            ['password', 'validatePassword'],
            ['verifyCode', 'captcha', 'captchaAction' => '/auth/captcha'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'verifyCode' => 'Подтвердите код',
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный адрес электронной почты или пароль.');
            }
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByPhone($this->phone);
        }
        return $this->_user;
    }
}
