<?php

namespace api\modules\v1\services;

use yii\data\ActiveDataProvider;
use api\modules\v1\models\Client;

/**
 * Class ClientModelService
 * @package api\modules\v1\services
 */
class ClientModelService extends ModelService
{
    public function index()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Client::find()
                ->isAccount()
        ]);

        $this->setResult($dataProvider);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function view(int $id): bool
    {
        $model = Client::find()
            ->where(['id' => $id])
            ->isAccount()
            ->one();

        $this->addData(['model' => $model]);
        $this->setResult($model);

        return (bool) $model;
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function create(): bool
    {
        $model = new Client(['account_id' => $this->getAccountId()]);
        $model->load($this->getData('bodyParams'), '');

        if ($model->save() === false && !$model->hasErrors()) {
            return false;
        }

        $this->addData(['model' => $model]);
        $this->setResult($model);
        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function update(int $id): bool
    {
        $model = Client::findOne(['id' => $id, 'account_id' => $this->getAccountId()]);
        $model->load($this->getData('bodyParams'), '');

        if ($model->save() === false && !$model->hasErrors()) {
            return false;
        }

        $this->addData(['model' => $model]);
        $this->setResult($model);
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return (bool) Client::deleteAll(['id' => $id, 'account_id' => $this->getAccountId()]);
    }
}