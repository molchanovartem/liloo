<?php

namespace site\services;

use site\forms\LoginForm;
use Yii;
use Exception;
use yii\base\Event;
use common\models\Account;
use common\models\User;
use common\models\UserProfile;
use site\forms\RegistrationForm;

/**
 * Class AuthService
 * @package site\services
 */
class AuthService extends \common\services\AuthService
{
    /**
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function registration()
    {
        $model = new RegistrationForm();
        $this->setData(['model' => $model]);
        if ($model->load($this->getData('post')) && $model->validate()) {
            $account = new Account();
            $account->save();

            $user = new User();
            $userProfile = new UserProfile();

            $user->login = Yii::$app->security->generateRandomString();
            $user->password = Yii::$app->security->generateRandomString(10);
            $user->account_id = $account->id;
            $user->type = $model->type;
            $user->refresh_token = Yii::$app->security->generateRandomString(255);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $user->save(false);
                $userProfile->user_id = $user->id;
                $userProfile->phone = $model->phone;
                $userProfile->save(false);
                $transaction->commit();
                $this->trigger(self::EVENT_USER_REGISTRATION, new Event(['sender' => $userProfile]));

                return true;
            } catch (Exception $exception) {
                $transaction->rollBack();

                throw $exception;
            }
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        $model = new LoginForm();
        $this->setData(['model' => $model]);

        if ($model->load($this->getData('post')) && $model->validate()) {
            return Yii::$app->user->login($model->getUser());
        }

        return false;
    }
}
