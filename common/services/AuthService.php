<?php

namespace common\services;

use Yii;
use Exception;
use yii\base\Event;
use admin\models\Notice;
use common\core\service\ModelService;
use common\models\Account;
use common\models\User;
use common\models\UserProfile;
use site\forms\RegistrationForm;

/**
 * Class AuthService
 * @package common\services
 */
class AuthService extends ModelService
{
    const EVENT_USER_REGISTRATION = 'registration';

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_USER_REGISTRATION, function ($model) {
            Yii::$app->adminNotice->createNotice(Notice::TYPE_USER_REGISTRATION, Notice::STATUS_UNREAD, 'text', $model->sender);
        });
    }

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

            $user->login = \Yii::$app->security->generateRandomString();
            $user->password = md5($model->password);
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

                return true;
            } catch (Exception $exception) {
                $transaction->rollBack();
                throw $exception;
            }
        }
    }
}
