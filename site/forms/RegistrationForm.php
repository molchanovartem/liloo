<?php

namespace site\forms;

use yii\base\Model;

/**
 * Class RegistrationForm
 * @package site\models
 */
class RegistrationForm extends Model
{
    public $phone;
    public $password;
    public $type;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['phone', 'password', 'type'], 'required', 'message' => 'Заполните поле'],
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