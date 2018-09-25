<?php

namespace api\services;

use api\exceptions\AttributeValidationError;
use api\exceptions\NotFoundEntryError;
use api\models\Service;

/**
 * Class ServiceService
 *
 * @package api\services
 */
class ServiceService
{
    /**
     * @param $attributes
     * @return Service
     * @throws AttributeValidationError
     */
    public function create($attributes)
    {
        return $this->save(new Service(), Service::SCENARIO_SERVICE, $attributes);
    }

    /**
     * @param int $id
     * @param $attributes
     * @return Service
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     */
    public function update(int $id, $attributes)
    {
        if (!$model = Service::find()->oneServiceById($id)) throw new NotFoundEntryError();

        return $this->save($model, Service::SCENARIO_SERVICE, $attributes);
    }

    /**
     * @param int $id
     * @return bool
     * @throws NotFoundEntryError
     */
    public function delete(int $id)
    {
        if (!$model = Service::find()->oneServiceById($id)) throw new NotFoundEntryError();

        return (bool)$model->delete();
    }

    /**
     * @param $data
     * @return Service
     * @throws AttributeValidationError
     */
    public function createGroup($attributes)
    {
        return $this->save(new Service(), Service::SCENARIO_GROUP, $attributes);
    }

    /**
     * @param int $id
     * @param $attributes
     * @return Service
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     */
    public function updateGroup(int $id, $attributes)
    {
        if (!$model = Service::find()->oneGroupById($id)) throw new NotFoundEntryError();

        return $this->save($model, Service::SCENARIO_GROUP, $attributes);
    }

    /**
     * @param int $id
     * @return bool
     * @throws NotFoundEntryError
     */
    public function deleteGroup(int $id): bool
    {
        if (!$model = Service::find()->oneGroupById($id)) throw new NotFoundEntryError();

        return (bool)$model->delete();
    }

    /**
     * @param Service $model
     * @param $scenario
     * @param array $attributes
     * @return Service
     * @throws AttributeValidationError
     */
    private function save(Service $model, $scenario, array $attributes)
    {
        $model->setScenario($scenario);
        $model->setAttributes($attributes);
        $model->is_group = (int) $scenario === Service::SCENARIO_GROUP;

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);
        return $model;
    }
}