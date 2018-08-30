<?php

namespace api\services;


use api\exceptions\AttributeValidationError;
use api\exceptions\NotFoundEntryError;
use api\models\Client;

class ClientService
{
    /**
     * @param array $attributes
     * @return Client
     * @throws AttributeValidationError
     */
    public function create(array $attributes)
    {
        return $this->save(new Client([
            'total_appointment' => 0,
            'total_failure_appointment' => 0,
            'total_spent_money' => 0
        ]), $attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return Client
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     */
    public function update(int $id, array $attributes)
    {
        if (!$model = Client::find()->oneById($id)) throw new NotFoundEntryError();

        return $this->save($model, $attributes);
    }

    /**
     * @param Client $model
     * @param array $attributes
     * @return Client
     * @throws AttributeValidationError
     */
    private function save(Client $model, array $attributes)
    {
        $model->setAttributes($attributes);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);
        return $model;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool) Client::deleteOneById($id);
    }
}