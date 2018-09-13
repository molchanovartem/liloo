<?php

namespace api\services;

use api\exceptions\AttributeValidationError;
use api\models\AccountTariff;
use common\models\BalanceJournal;
use common\models\TariffPrice;
use Yii;

/**
 * Class TariffService
 * @package api\services
 */
class TariffService extends Service
{
    /**
     * @param array $attributes
     * @return null
     * @throws \yii\db\Exception
     */
    public function buyTariff(array $attributes)
    {
        //TODO: нельзя создать тариф без валидации
        return $this->save(new AccountTariff(), $attributes);
    }

    /**
     * @param AccountTariff $model
     * @param array $attributes
     * @return null
     * @throws \yii\db\Exception
     */
    private function save(AccountTariff $model, array $attributes)
    {
        return $this->wrappedTransaction(function () use ($model, $attributes) {
            $model->setAttributes($attributes);
            $model->end_date = $this->setDateEnd($this->getTariffDays($model->price_id));

            if (!$model->validate()) throw new AttributeValidationError($model->getErrors());
            $model->save(false);
            Yii::$app->balance->decrease($model->account_id, $this->getTariffPrice($model->price_id), BalanceJournal::TYPE_REASON_SELL_TARIFF, $model);

            return $model;
        });
    }

    /**
     * @param $priceId
     * @return array|\yii\db\ActiveRecord[]
     */
    private function getTariffDays($priceId)
    {
        return TariffPrice::find()
            ->where(['id' => $priceId])
            ->one()['days'];
    }

    /**
     * @param $days
     * @return false|string
     */
    private function setDateEnd($days)
    {
        return date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date("m"), date("d") + $days, date("Y")));
    }

    /**
     * @param $priceId
     * @return mixed
     */
    private function getTariffPrice($priceId)
    {
        return TariffPrice::find()
            ->where(['id' => $priceId])
            ->one()['price'];
    }
}
