<?php

namespace api\repositories;

use api\models\Specialization;
/**
 * Class SpecializationRepository
 * @package api\repositories
 */
class SpecializationRepository extends Repository
{
    protected static $instance;

    /**
     * @var array
     */
    private $allData;


    public function getAll(): array
    {
        if ($this->allData) return $this->allData;

        return $this->allData = Specialization::find()
            ->indexBy('id')
            ->all();
    }

    /**
     * @param int|array $id
     * @return mixed|null
     */
    public function findByIdFromAll($id)
    {
        if (is_array($id)) {
            return array_intersect_key($this->getAll(), array_flip($id));
        }

        return $this->getAll()[$id] ?? null;
    }

    /**
     * @param $id
     * @return bool
     */
    public function existByIdFromAll($id): bool
    {
        return (bool) $this->findByIdFromAll($id);
    }

    /**
     * @param Specialization $specialization
     * @return bool
     */
    public function create(Specialization $specialization)
    {
        return $specialization->save(false);
    }
}