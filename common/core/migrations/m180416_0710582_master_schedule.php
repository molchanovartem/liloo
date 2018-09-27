<?php

use yii\db\Migration;

/**
 * Class m180416_0710582_master_schedule
 */
class m180416_0710582_master_schedule extends Migration
{
    protected $tableName = '{{%master_schedule}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'master_id' => $this->integer()->notNull(),
            'salon_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'start_date' => $this->dateTime()->notNull(),
            'end_date' => $this->dateTime()->notNull()
        ]);

        $this->createIndex('ix-master_schedule-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-master_schedule-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-master_schedule-master_id', $this->tableName, 'master_id');
        $this->addForeignKey('fk-master_schedule-master_id', $this->tableName, 'master_id', '{{%master}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-master_schedule-salon_id', $this->tableName, 'salon_id');
        $this->addForeignKey('fk-master_schedule-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
