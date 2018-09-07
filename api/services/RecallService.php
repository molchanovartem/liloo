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
     * @return Recall
     * @throws AttributeValidationError
     */
    public function create(array $attributes, $type)
    {
        return $this->save(new Recall(), $attributes, $type);
    }

    /**
     * @param Recall $model
     * @param array $attributes
     * @return Recall
     * @throws AttributeValidationError
     */
    private function save(Recall $model, array $attributes, $type)
    {
        $model->setAttributes($attributes);
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