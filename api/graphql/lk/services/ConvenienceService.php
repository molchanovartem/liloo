<?php

namespace api\graphql\lk\services;

use common\models\Convenience;
use api\graphql\core\errors\AttributeValidationError;
use api\graphql\core\errors\NotFoundEntryError;

/**
 * Class ConvenienceService
 *
 * @package api\graphql\lk\services
 */
class ConvenienceService
{
    /**
     * @param $data
     * @return Convenience
     * @throws AttributeValidationError
     */
    public function create($data)
    {
        $model = new Convenience();
        $model->setAttributes($data);

        return $this->save($model);
    }

    /**
     * @param int $id
     * @param $data
     * @return Convenience
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     */
    public function update(int $id, $data)
    {
        if ($model = Convenience::findOne($id)) throw new NotFoundEntryError();

        $model->setAttributes($data);

       return $this->save($model);
    }

    /**
     * @param Convenience $model
     * @return Convenience
     * @throws AttributeValidationError
     */
    protected function save(Convenience $model)
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
        if (($result = Convenience::deleteAll(['id' => $id])) == 0) throw new NotFoundEntryError();
        return (bool)$result;
    }
}