<?php

namespace api\repositories;

use api\models\Service;

/**
 * Class ServiceRepository
 * @package api\repositories
 */
class ServiceRepository extends Repository
{
    /**
     * @var null
     */
    protected static $instance = null;

    private $allData = [];

    /**
     * @return array
     */
    public function getAll(): array
    {
        if ($this->allData) return $this->allData;

        $models = Service::find()
            ->isAccount()
            ->indexBy('id')
            ->all();

        return $this->allData = $models;
    }

    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findById(int $id)
    {
        return Service::find()
            ->byId($id)
            ->isAccount()
            ->one();
    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function findByIdFromAll(int $id)
    {
        return $this->getAll()[$id] ?? null;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existByIdFromAll(int $id): bool
    {
        return (bool) $this->findByIdFromAll($id);
    }
}