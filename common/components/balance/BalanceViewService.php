<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 01.11.17
 * Time: 14:03
 */

namespace app\components\balance;


use Yii;
use app\service\BaseViewService;

class BalanceViewService extends BaseViewService
{
    public static function getTypeOperationList(): array
    {
        return [
            Balance::TYPE_OPERATION_INCREASE => Yii::t('app', 'Increased'),
            Balance::TYPE_OPERATION_DECREASE => Yii::t('app', 'Decreased'),
        ];
    }

    public static function getTypeOperationName($type): string
    {
        return self::getTypeOperationList()[$type];
    }
}