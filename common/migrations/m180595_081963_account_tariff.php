<?php

use yii\db\Migration;

/**
 * Class m180595_081963_account_tariff
 */
class m180595_081963_account_tariff extends Migration
{
    protected $tableName = '{{%account_tariff}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'tariff_id' => $this->integer()->notNull(),
            'end_date' => $this->dateTime()->notNull(),
        ]);

        $this->execute("ALTER TABLE {$this->tableName} ADD `start_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `tariff_id`;");

        $this->createIndex('ix-account_tariff-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-account_tariff-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-account_tariff-tariff_id', $this->tableName, 'tariff_id');
        $this->addForeignKey('fk-account_tariff-tariff_id', $this->tableName, 'tariff_id', '{{%tariff}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
