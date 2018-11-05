<?php

namespace site\services;

use Exception;
use Yii;
use site\events\RegistrationEvent;
use common\models\Account;
use common\models\User;
use common\models\UserProfile;
use site\forms\LoginForm;
use site\forms\RegistrationForm;

/**
 * Class AuthService
 *
 * @package site\services
 */
class AuthService extends \common\services\AuthService
{
    /**
     * @return bool
     * @throws Exception
     */
    public function registration(): bool
    {
        $form = new RegistrationForm();
        $this->setData(['form' => $form]);

        if ($form->load($this->getData('post')) && $form->validate()) {
            return $this->wrappedTransaction(function () use ($form) {
                $account = new Account();
                $account->save(false);

                $login = Yii::$app->security->generateRandomString(10);
                $password = 123;

                $user = new User([
                    'account_id' => $account->id,
                    'type' => $form->type,
                    'login' => $login,
                    'password' => Yii::$app->security->generatePasswordHash($password),
                    'status' => User::STATUS_ACTIVE,
                    'refresh_token' => Yii::$app->security->generateRandomString(255),
                    'token' => Yii::$app->security->generateRandomString(255),
                ]);
                $user->setAttributes($form->getAttributes());
                $user->save(false);

                $userProfile = new UserProfile([
                    'user_id' => $user->id,
                    'phone' => $form->setNormalizePhone(),
                    'name' => 'Новый пользователь',
                    'country_id' => 1, //Россия
                ]);
                $userProfile->save(false);

                $event = new RegistrationEvent([
                    'login' => $login,
                    'password' => $password,
                    'phone' => $userProfile->phone,
                    'sender' => $userProfile
                ]);

                $this->trigger(self::EVENT_USER_REGISTRATION, $event);

                return true;
            });
        }

        return false;
    }

    /**
     * @return bool
     */
    public function login(): bool
    {
        $form = new LoginForm();
        $this->setData(['form' => $form]);

        if ($form->load($this->getData('post')) && $form->validate()) {
            return Yii::$app->user->login($form->getUser());
        }
        return false;
    }
}
