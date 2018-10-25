<?php

namespace common\core\service;

use Yii;

/**
 * Class ModelService
 *
 * @package common\core\service
 */
abstract class ModelService extends Service
{
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
}
