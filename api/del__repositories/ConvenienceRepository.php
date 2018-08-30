<?php

namespace api\repositories;

use api\models\Convenience;

/**
 * Class ConvenienceRepository
 * @package api\repositories
 */
class ConvenienceRepository extends Repository
{
    protected static $instance = null;

    protected $allData = [];

    /**
     * @return array
     */
    public function getAll(): array
    {
        if ($this->allData) return $this->allData;

        $rows = Convenience::find()
            ->indexBy('id')
            ->all();

        return $this->allData = $rows;
    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function findByIdFromAll(int $id)
    {
        return $this->getAll()[$id] ?? null;
    }
}