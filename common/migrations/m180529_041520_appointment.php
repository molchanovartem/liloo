<?php

use yii\db\Migration;

/**
 * Class m180529_041520_appointment
 */
class m180529_041520_appointment extends Migration
{
    protected $tableName = '{{%appointment}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'salon_id' => $this->integer(),
            'master_id' => $this->integer(),
            'client_id' => $this->integer()->notNull(),
            'owner_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'start_date' => $this->dateTime()->notNull(),
            'end_date' => $this->dateTime()->notNull()
        ]);

        $this->createIndex('ix-appointment-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-appointment-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-appointment-user_id', $this->tableName, 'user_id');
        $this->addForeignKey('fk-appointment-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'NO ACTION', 'CASCADE');

        $this->createIndex('ix-appointment-salon_id', $this->tableName, 'salon_id');
        $this->addForeignKey('fk-appointment-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'NO ACTION', 'CASCADE');

        $this->createIndex('ix-appointment-master_id', $this->tableName, 'master_id');
        $this->addForeignKey('fk-appointment-master_id', $this->tableName, 'master_id', '{{%master}}', 'id', 'NO ACTION', 'CASCADE');

        $this->createIndex('ix-appointment-client_id', $this->tableName, 'client_id');
        $this->addForeignKey('fk-appointment-client_id', $this->tableName, 'client_id', '{{%client}}', 'id', 'NO ACTION', 'CASCADE');

        $this->createIndex('ix-appointment-owner_id', $this->tableName, 'owner_id');
        $this->addForeignKey('fk-appointment-owner_id', $this->tableName, 'owner_id', '{{%user}}', 'id', 'NO ACTION', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
