<?php

namespace site\controllers;

use common\models\Account;
use site\models\SignupForm;
use Yii;

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
        Yii::$app->notice->createNotice(1,1,1,1);
    });
    }

    protected function initEvents()
    {

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

                $this->trigger(1, [$user, $userProfile]);
            } catch (Exception $exception) {
                $transaction->rollBack();
                throw $exception;
            }
            return $this->goHome();
        }

        return $this->render('signup', compact('model'));
    }
}