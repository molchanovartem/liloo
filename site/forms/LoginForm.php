<?php

namespace site\forms;

use Yii;
use yii\base\Model;
use common\models\UserProfile;
use common\models\UserIdentity;

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
    private $user = null;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            // Формат телефона, длина
            [['phone', 'password'], 'required'],
            [['phone'], 'integer'],
            ['verifyCode', 'captcha', 'captchaAction' => '/auth/captcha'],
            ['password', 'validatePassword'],
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
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getUser()
    {
        if (!$this->user) {
            $this->user = UserIdentity::find()
                ->alias('u')
                ->leftJoin(UserProfile::tableName() . ' up', 'up.user_id = u.id')
                ->where(['up.phone' => $this->phone])
                ->andWhere(['u.type' => UserIdentity::TYPE_CLIENT])
                ->one();
        }
        return $this->user;
    }
}
