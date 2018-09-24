<?php

namespace api\services;

use Yii;
use common\models\BalanceJournal;
use api\models\TariffPrice;
use api\exceptions\AttributeValidationError;
use api\models\AccountTariff;

/**
 * Class TariffService
 * @package api\services
 */
class TariffService extends Service
{
    /**
     * @param int $priceId
     * @return null
     * @throws AttributeValidationError
     * @throws \yii\db\Exception
     */
    public function buyTariff(int $priceId)
    {
        $price = TariffPrice::find()->oneById($priceId);

        if ($price->price > Yii::$app->account->getBalance()) throw new AttributeValidationError(['Недостаточно средств']);
        /*
         * @todo
         * Проверка на количество использований (Tariff::quantity)
         */

        return $this->save(new AccountTariff(), [
            'tariff_id' => $price->tariff_id,
            'price_id' => $price->id
        ]);
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
            ->one()['day'];
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
