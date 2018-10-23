<?php

namespace api\graphql\lk\services;

use api\graphql\core\errors\AttributeValidationError;
use api\graphql\core\errors\NotFoundEntryError;
use api\models\lk\Client;

/**
 * Class ClientService
 *
 * @package api\graphql\lk\services
 */
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
        $model = Client::find()
            ->byCurrentAccountId()
            ->oneById($id);

        if (!$model) throw new NotFoundEntryError();

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