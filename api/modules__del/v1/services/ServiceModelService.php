<?php

namespace api\modules\v1\services;

use yii\data\ActiveDataProvider;
use api\modules\v1\models\Service;

/**
 * Class ServiceModelService
 * @package api\modules\v1\services
 */
class ServiceModelService extends ModelService
{
    public function index()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Service::find()
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
        $model = Service::find()
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
        $model = new Service(['account_id' => $this->getAccountId()]);

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
        $model = Service::find()
            ->where(['id' => $id])
            ->isAccount()
            ->one();

        if (!$model) {
            return false;
        }

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
        return (bool)Service::deleteAll(['id' => $id, 'account_id' => $this->getAccountId()]);
    }
}