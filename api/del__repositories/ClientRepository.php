<?php

namespace api\repositories;

use api\models\Client;

/**
 * Class ClientRepository
 * @package api\repositories
 */
class ClientRepository extends Repository
{
    protected static $instance;

    private $allItems = [];

    /**
     * @return array
     */
    public function getAll(): array
    {
        if ($this->allItems) return $this->allItems;

        $rows = Client::find()
            ->isAccount()
            ->indexBy('id')
            ->all();

        return $this->allItems = $rows;
    }

    /**
     * @param int $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findById(int $id)
    {
        return Client::find()
            ->byId($id)
            ->isAccount()
            ->one();
    }
}