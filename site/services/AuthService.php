<?php

namespace site\services;

use Exception;
use Yii;
use yii\base\Event;
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

                $user = new User([
                    'account_id' => $account->id,
                    'status' => User::STATUS_ACTIVE,
                    'refresh_token' => Yii::$app->security->generateRandomString(255)
                ]);
                $user->setAttributes($form->getAttributes());
                $user->save(false);

                $userProfile = new UserProfile([
                    'user_id' => $user->id,
                    'phone' => (int) filter_var($form->phone, FILTER_SANITIZE_NUMBER_INT),
                ]);
                $userProfile->save(false);

                $this->trigger(self::EVENT_USER_REGISTRATION, new Event(['sender' => $userProfile]));
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
