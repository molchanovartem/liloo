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
     * @param $data
     * @return Service
     * @throws AttributeValidationError
     */
    public function create($data)
    {
        $model = new Service();
        $model->setScenario(Service::SCENARIO_SERVICE);
        $model->setAttributes($data);

        return $this->save($model);
    }

    /**
     * @param int $id
     * @param $data
     * @return Service
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     */
    public function update(int $id, $data)
    {
        if (!$model = Service::find()->oneServiceById($id)) throw new NotFoundEntryError();

        $model->setScenario(Service::SCENARIO_SERVICE);
        $model->setAttributes($data);

        return $this->save($model);
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
    public function createGroup($data)
    {
        $model = new Service();
        $model->setScenario(Service::SCENARIO_GROUP);
        $model->setAttributes($data);

        return $this->save($model);
    }

    /**
     * @param int $id
     * @param $data
     * @return Service
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     */
    public function updateGroup(int $id, $data)
    {
        if (!$model = Service::find()->oneGroupById($id)) throw new NotFoundEntryError();

        $model->setScenario(Service::SCENARIO_GROUP);
        $model->setAttributes($data);

        return $this->save($model);
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
     * @return Service
     * @throws AttributeValidationError
     */
    private function save(Service $model)
    {
        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);
        return $model;
    }
}