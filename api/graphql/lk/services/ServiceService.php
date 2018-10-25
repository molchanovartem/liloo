<?php

namespace api\graphql\lk\services;

use api\graphql\core\errors\AttributeValidationError;
use api\graphql\core\errors\NotFoundEntryError;
use api\models\lk\Service;
use common\core\service\ModelService;

/**
 * Class ServiceService
 *
 * @package api\graphql\lk\services
 */
class ServiceService extends ModelService
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
        return $this->save($this->getServiceModel($id), Service::SCENARIO_SERVICE, $attributes);
    }

    /**
     * @param int $id
     * @return bool
     * @throws NotFoundEntryError
     */
    public function delete(int $id)
    {
        $model = $this->getServiceModel($id);

        return (bool)$model->delete();
    }

    private function getServiceModel(int $id)
    {
        $model = Service::find()
            ->byCurrentAccountId()
            ->isService()
            ->oneById($id);

        if (!$model) throw new NotFoundEntryError();

        return $model;
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