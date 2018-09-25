<?php

namespace site\forms;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package site\forms
 */
class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
        ];
    }

    public function validatePassword()
    {
        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'Incorrect username or password.');
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            $user = User::findByUsername($this->login);
            Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    private function getUser()
    {

        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->login);

        }
        return $this->_user;
    }
}
