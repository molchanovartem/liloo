<?php

namespace site\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $phone;
    public $password;
    public $type;

    public function rules()
    {
        return [
            [['phone', 'password', 'type'], 'required', 'message' => 'Заполните поле'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone'    => 'Телефон',
            'password' => 'Пароль',
            'type'     => 'Тип',
        ];
    }

}