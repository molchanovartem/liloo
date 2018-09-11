<?php

use yii\db\Migration;

/**
 * Class m180595_081961_balance_journal
 */
class m180595_081961_balance_journal extends Migration
{
    protected $tableName = '{{%balance_journal}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'type_operation' => $this->integer()->notNull(),
            'sum' => $this->decimal(18, 2)->notNull(),
            'reason' => $this->string()->notNull(),
        ]);

        $this->execute("ALTER TABLE {$this->tableName} ADD `create_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `reason`;");

        $this->createIndex('ix-balance_journal-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-balance_journal-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
