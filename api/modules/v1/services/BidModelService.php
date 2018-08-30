<?php

namespace app\modules\api\services\v1;

use app\core\models\Bid;
use app\core\models\Client;
use app\core\exceptions\NoModelException;
use app\modules\api\forms\v1\ClientForm;

/**
 * Class BidModelService
 * @package app\modules\api\services\v1
 */
class BidModelService extends ModelService
{
    /**
     * @param int $id
     * @throws NoModelException
     */
    public function getItem(int $id)
    {
        $query = Bid::find()
            ->where(['id' => $id]);

        if ($this->isDataTypeArray()) {
            $query->asArray();
        }

        if (!$item = $query->one()) {
            throw new NoModelException();
        }

        $this->setData([
            'item' => $item
        ]);
    }

    public function getItems()
    {
        $query = Bid::find();

        if ($this->isDataTypeArray()) {
            $query->asArray();
        }

        $this->setData([
            'items' => $query->all()
        ]);
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        $form = new ClientForm();
        $model = new Client();

        $this->setData([
            'form' => $form,
            'model' => $model,
            'attributes' => $model->getAttributes()
        ]);
        return $this->save($form, $model);
    }

    /**
     * @param int $id
     * @return bool
     * @throws NoModelException
     */
    public function update(int $id): bool
    {
        $model = Client::find()
            ->where(['id' => $id])
            ->one();

        if (!$model) {
            throw new NoModelException();
        }

        $form = new ClientForm();
        $form->setAttributes($model->getAttributes());

        $this->setData([
            'form' => $form,
            'model' => $model,
            'attributes' => $model->getAttributes()
        ]);
        return $this->save($form, $model);
    }

    /**
     * @param ClientForm $form
     * @param Client $model
     * @return bool
     */
    private function save(ClientForm $form, Client $model): bool
    {
        $form->load($this->getData('post'));

        if ($form->validate()) {
            $model->setAttributes($form->getAttributes());

            return $model->save(false);
        }
        $this->readModelErrors($model);
        return false;
    }
}