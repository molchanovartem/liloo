<?php

namespace site\forms;

use yii\base\Model;
use common\models\UserProfile;

/**
 * Class RegistrationForm
 * @package site\models
 */
class RegistrationForm extends Model
{
    public $phone;
    public $type;
    public $verifyCode;
    public $deal;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['phone', 'type'], 'required'],
            ['verifyCode', 'captcha', 'captchaAction' => '/auth/captcha'],
            ['phone', function ($attribute) {
                $user = UserProfile::find()->where(['phone' => $this->setNormalizePhone(), 'type' => $this->type])->one();
                if (!empty($user)) {
                    $this->addError($attribute, 'Пользователь с таким телефоном уже существует.');
                }
            }],
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
            'type' => 'Тип',
            'deal' => ''
        ];
    }

    /**
     * @return int
     */
    public function setNormalizePhone()
    {
        return (int)filter_var($this->phone, FILTER_SANITIZE_NUMBER_INT);
    }
}
