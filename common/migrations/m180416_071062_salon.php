<?php

use yii\db\Migration;

/**
 * Class m180426_045014_salon
 */
class m180416_071062_salon extends Migration
{
    protected $tableName = '{{%salon}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'address' => $this->string(),
            'phone' => $this->bigInteger(20)
        ]);

        $this->createIndex('ix-salon-user_id', $this->tableName, 'user_id');
        $this->addForeignKey('fk-salon-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-salon-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-salon-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
