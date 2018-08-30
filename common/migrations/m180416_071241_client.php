<?php

use yii\db\Migration;

/**
 * Class m180416_071241_client
 */
class m180416_071241_client extends Migration
{
    protected $tableName = '{{%client}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'country_id' => $this->integer()->notNull(),
            'city_id' => $this->integer(),
            'status' => $this->integer()->notNull(),
            'surname' => $this->string(),
            'name' => $this->string()->notNull(),
            'patronymic' => $this->string(),
            'date_birth' => $this->date(),
            'phone' => $this->string(20),
            'address' => $this->string(),
            'total_appointment' => $this->integer()->notNull(),
            'total_failure_appointment' => $this->integer()->notNull(),
            'total_spent_money' => $this->decimal(15,2)->notNull(),
            'date_last_appointment' => $this->date()
        ]);

        $this->createIndex('ix-client-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-client-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-client-country_id', $this->tableName, 'country_id');
        $this->addForeignKey('fk-client-country_id', $this->tableName, 'country_id', '{{%country}}', 'id', 'NO ACTION', 'CASCADE');

        $this->createIndex('ix-client-city_id', $this->tableName, 'city_id');
        $this->addForeignKey('fk-client-city_id', $this->tableName, 'city_id', '{{%city}}', 'id', 'NO ACTION', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
