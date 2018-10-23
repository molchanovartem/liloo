<?php

namespace api\services\common;

use GraphQL\Error\Error;
use Yii;
use common\models\User;
use api\services\Service;
use api\graphql\core\errors\AttributeValidationError;

/**
 * Class UserService
 *
 * @package api\services\common
 */
class UserService extends Service
{
    /**
     * @param $login
     * @param $password
     * @return mixed|string
     * @throws Error
     * @throws \yii\base\Exception
     */
    public function login($login, $password)
    {
        $user = User::find()
            ->alias('u')
            ->joinWith('profile p')
            ->where(['p.phone' => $login])
            ->one();

        if (($user && Yii::$app->security->validatePassword($password, $user->password)) === false) throw new AttributeValidationError(['Неправильный логи или пароль']);

        $user->token = Yii::$app->security->generateRandomString(255);
        $user->save(false);

        return $user->token;
    }
}