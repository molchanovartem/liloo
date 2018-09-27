<?php

use yii\db\Migration;

/**
 * Class m180545_081561_recall
 */
class m180545_081561_recall extends Migration
{
    protected $tableName = '{{%recall}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'appointment_id' => $this->integer(),
            'parent_id' => $this->integer(),
            'text' => $this->string()->notNull(),
            'assessment' => $this->integer()->defaultValue(0),
            'type' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
        ]);

        $this->execute("ALTER TABLE {$this->tableName} ADD `create_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `status`;");

        $this->createIndex('ix-recall-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-recall-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-recall-appointment_id', $this->tableName, 'appointment_id');
        $this->addForeignKey('fk-recall-appointment_id', $this->tableName, 'appointment_id', '{{%appointment}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-recall-user_id', $this->tableName, 'user_id');
        $this->addForeignKey('fk-recall-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'NO ACTION', 'CASCADE');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
