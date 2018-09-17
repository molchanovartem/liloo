<?php

namespace admin\services;

use yii\data\ActiveDataProvider;
use admin\forms\TariffForm;
use common\core\service\ModelService;
use common\models\Tariff;
use common\models\TariffPrice;

/**
 * Class TariffService
 * @package admin\services
 */
class TariffService extends ModelService
{
    public function getDataProvider()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tariff::find(),
            'pagination' => ['pageSize' => 10],
        ]);

        $this->setData(['provider' => $dataProvider]);
    }

    /**
     * @param $type
     * @param array $params
     * @return bool
     */
    public function save($type, $params = [])
    {
        $type == 'create' ? $model = new Tariff() : $model = Tariff::find()->where(['id' => $params['id']])->one();
        $form = new TariffForm;
        $form->setAttributes($model->getAttributes());

        $this->setData([
            'form' => $form,
            'model' => $model
        ]);
        if ($form->load($this->getData('post')) && $form->validate()) {
            $model->setAttributes($form->getAttributes());
            $model->access = $form->access;
            $model->save(false);

            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->findTariff($id);

        return $this->getData()['tariff']->delete();
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function findTariff($id)
    {
        if (($model = Tariff::findOne($id)) == null) throw new \Exception('Not find any tariff');

        $this->setData(['tariff' => $model]);
    }

    /**
     * @param $tariffId
     * @return bool
     */
    public function savePrice($tariffId)
    {
        $model = new TariffPrice(['tariff_id' => $tariffId]);
        $this->setData([
            'model' => $model,
        ]);

        return $model->load($this->getData('post')) && $model->save();
    }

    /**
     * @param $id
     */
    public function findTariffPrice($id)
    {
        $this->setData(['price' => TariffPrice::find()->where(['tariff_id' => $id])->all()]);
    }
}