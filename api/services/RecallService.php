<?php

namespace api\services;

use api\exceptions\AttributeValidationError;
use api\models\Recall;

/**
 * Class RecallService
 * @package api\services
 */
class RecallService extends Service
{
    /**
     * @param array $attributes
     * @param $type
     * @param $modelScenario
     * @return Recall
     * @throws AttributeValidationError
     */
    public function create(array $attributes, $type, $modelScenario)
    {
        return $this->save(new Recall(), $attributes, $type, $modelScenario);
    }

    /**
     * @param Recall $model
     * @param array $attributes
     * @param $type
     * @param $modelScenario
     * @return Recall
     * @throws AttributeValidationError
     */
    private function save(Recall $model, array $attributes, $type, $modelScenario)
    {
        $model->setAttributes($attributes);
        $model->setScenario($modelScenario);
        $model->type = $type;

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
        return (bool)Recall::deleteById($id);
    }
}