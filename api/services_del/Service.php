<?php

namespace api\services;

use Yii;
use yii\base\Component;

/**
 * Class Service
 *
 * @package api\services
 */
class Service extends Component
{
    /**
     * @param callable $function
     * @return null
     * @throws \yii\db\Exception
     */
    protected function wrappedTransaction(callable $function)
    {
        $result = null;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $result = $function();
            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }
        return $result;
    }

    /**
     * @return int
     */
//    protected function getUserId()
//    {
//        return Yii::$app->user->getId();
//    }

    /**
     * @return mixed
     */
//    protected function getAccountId()
//    {
//        return Yii::$app->account->getId();
//    }
}