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
            'author_id' => $this->integer()->notNull(),
            'appointment_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'text' => $this->string()->notNull(),
            'assessment' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'create_time' => $this->dateTime(),
        ]);

        $this->createIndex('ix-recall-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-recall-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-recall-appointment_id', $this->tableName, 'appointment_id');
        $this->addForeignKey('fk-recall-appointment_id', $this->tableName, 'appointment_id', '{{%appointment}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-recall-author_id', $this->tableName, 'author_id');
        $this->addForeignKey('fk-recall-author_id', $this->tableName, 'author_id', '{{%user}}', 'id', 'NO ACTION', 'CASCADE');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
