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
     * @param $data
     * @return Specialization
     * @throws AttributeValidationError
     */
    public function create($data)
    {
        $model = new Specialization();
        $model->setAttributes($data);

        return $this->save($model);
    }

    /**
     * @param int $id
     * @param $data
     * @return Specialization
     * @throws AttributeValidationError
     */
    public function update(int $id, $data)
    {
        $model = Specialization::findOne($id);
        $model->setAttributes($data);

        return $this->save($model);
    }

    /**
     * @param Specialization $model
     * @return Specialization
     * @throws AttributeValidationError
     */
    protected function save(Specialization $model)
    {
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