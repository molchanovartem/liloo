<?php

use yii\db\Migration;

/**
 * Class m180416_0710582_master_schedule
 */
class m180416_0710583_master_service extends Migration
{
    protected $tableName = '{{%master_service}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'master_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'salon_id' => $this->integer()->notNull()
        ]);

        $this->createIndex('ix-master_service-master_id-service_id-salon_id', $this->tableName, ['master_id', 'service_id', 'salon_id'], true);

        $this->createIndex('ix-master_service-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-master_service-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey('fk-master_service-master_id', $this->tableName, 'master_id', '{{%master}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-master_service-service_id', $this->tableName, 'service_id', '{{%service}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-master_service-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
