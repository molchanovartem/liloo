<?php

namespace site\controllers;

use common\models\Account;
use common\models\User;
use common\models\UserProfile;
use site\models\SignupForm;
use Yii;
use yii\db\Exception;

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


}
