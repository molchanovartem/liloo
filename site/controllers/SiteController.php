<?php

namespace site\controllers;

use common\models\Account;
use common\models\User;
use common\models\UserProfile;
use site\models\SignupForm;
use Yii;

/**
 * Class SiteController
 * @package site\controllers
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
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
            $user->save();

            $userProfile->user_id = $user->id;
            $userProfile->phone = $model->phone;

            if ($userProfile->save()) {
                return $this->goHome();
            }
        }

        return $this->render('signup', compact('model'));
    }
}
