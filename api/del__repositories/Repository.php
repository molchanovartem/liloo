<?php

namespace api\repositories;

use yii\base\InvalidConfigException;

/**
 * Class Repository
 * @package api\repositories
 */
abstract class Repository implements RepositoryInterface
{
    protected static $instance = null;
    /**
     * @var null
     */
    //protected $entityClass = null;

    public function __construct()
    {
        //if ($this->entityClass === null) throw new InvalidConfigException('Is null entityClass');
    }

    public static function getInstance()
    {
        return static::$instance ?? (static::$instance = new static());
    }


    /**
     * @param array $rows
     * @param null $indexBy
     * @return array
     */
    protected function populateRows($rows = [], $indexBy = null)
    {
        if (!$indexBy) {
            return array_map(function ($item) {
                return $this->populate($item);
            }, $rows);
        }

        $items = [];
        foreach ($rows as $row) {
            $items[$row[$indexBy] ?? null] = $this->populate($row);
        }
        return $items;
    }

    /**
     * @param array $attributes
     * @return Entity
     */
    protected function populate(array $attributes)
    {
        /**
         * @var $class Entity
         */
        $class = $this->entityClass;

        return $class::create($attributes);
    }
}