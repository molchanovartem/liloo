<?php

namespace api\services;

use api\exceptions\AttributeValidationError;
use api\exceptions\NotFoundEntryError;
use api\models\Specialization;

/**
 * Class SpecializationService
 *
 * @package api\services
 */
class SpecializationService
{
    /**
     * @param $attributes
     * @return Specialization
     * @throws AttributeValidationError
     */
    public function create($attributes)
    {
        return $this->save(new Specialization(), $attributes);
    }

    /**
     * @param int $id
     * @param $attributes
     * @return Specialization
     * @throws AttributeValidationError
     */
    public function update(int $id, $attributes)
    {
        return $this->save(Specialization::findOne($id), $attributes);
    }

    /**
     * @param Specialization $model
     * @param $attributes
     * @return Specialization
     * @throws AttributeValidationError
     */
    protected function save(Specialization $model, $attributes)
    {
        $model->setAttributes($attributes);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);

        return $model;
    }

    /**
     * @param int $id
     * @return bool
     * @throws NotFoundEntryError
     */
    public function delete(int $id)
    {
        if (($result = Specialization::deleteAll(['id' => $id])) == 0) throw new NotFoundEntryError();

        return (bool)$result;
    }
}