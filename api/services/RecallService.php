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
    public function create(array $attributes)
    {
        return $this->save(new Recall(), $attributes);
    }

    /**
     * @param Recall $model
     * @param array $attributes
     * @return Recall
     * @throws AttributeValidationError
     */
    private function save(Recall $model, array $attributes)
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
        return (bool)Recall::deleteById($id);
    }
}