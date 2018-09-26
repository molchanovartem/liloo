<?php

use yii\db\Migration;

/**
 * Class m180416_071005_city
 */
class m180416_071005_city extends Migration
{
    protected $tableName = '{{%city}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'phone_code' => $this->integer(),
            'latitude' => $this->decimal(9,6),
            'longitude' => $this->decimal(9,6),
        ]);

        $this->createIndex('ix-city-country_id', $this->tableName, 'country_id');
        $this->addForeignKey('fk-city-country_id', $this->tableName, 'country_id', '{{%country}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
