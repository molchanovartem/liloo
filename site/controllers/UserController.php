<?php

namespace site\controllers;

use admin\models\Notice;
use common\models\Account;
use common\models\User;
use common\models\UserProfile;
use Exception;
use site\models\SignupForm;
use Yii;
use yii\base\Event;

/**
 * Class UserController
 * @package site\controllers
 */
class UserController extends Controller
{
    const EVENT_USER_REGISTRATION = 'registration';

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_USER_REGISTRATION, function ($model) {
            Yii::$app->admin_notice->createNotice(Notice::TYPE_USER_REGISTRATION, Notice::STATUS_UNREAD, 'text', $model->sender);
        });
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $account = new Account();
            $account->save();

            $user = new User();
            $userProfile = new UserProfile();

            $user->login = \Yii::$app->security->generateRandomString();
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            $user->account_id = $account->id;
            $user->type = $model->type;


            $transaction = Yii::$app->db->beginTransaction();
            try {
                $user->save(false);

                $userProfile->user_id = $user->id;
                $userProfile->phone = $model->phone;
                $userProfile->save(false);

                $transaction->commit();

                $this->trigger(self::EVENT_USER_REGISTRATION, new Event(['sender' => $userProfile]));
            } catch (Exception $exception) {
                $transaction->rollBack();
                throw $exception;
            }

            return $this->goHome();
        }

        return $this->render('signup', compact('model'));
    }
}