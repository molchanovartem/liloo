<?php

namespace site\forms;

use Yii;
use yii\base\Model;
use site\models\User;

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

            if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Неверный номер телефона или пароль.');
            }
        }
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
