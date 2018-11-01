<?php

namespace site\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Class ResetPasswordForm
 * @package site\forms
 */
class ResetPasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;
    public $repeatNewPassword;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'repeatNewPassword',], 'required'],
            ['oldPassword', function ($attribute) {
                $user = User::findOne(Yii::$app->user->getId());
                if (!Yii::$app->security->validatePassword($this->$attribute, $user->password)) {
                    $this->addError($attribute, 'Неверный пароль.');
                }
            }],
            ['newPassword', 'compare', 'compareAttribute' => 'repeatNewPassword'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'oldPassword' => 'Старый пароль',
            'newPassword' => 'Новый пароль',
            'repeatNewPassword' => 'Повторите новый пароль',
        ];
    }
}
