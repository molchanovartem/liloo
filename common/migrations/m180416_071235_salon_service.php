<?php

use yii\db\Migration;

/**
 * Class m180416_071235_salon_service
 */
class m180416_071235_salon_service extends Migration
{
    protected $tableName = '{{%salon_service}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'salon_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'service_price' => $this->decimal(15, 2)->notNull(),
            'service_duration' => $this->integer()->notNull()
        ]);

        $this->createIndex('ix-salon_service-account_id', $this->tableName, ['salon_id', 'service_id'], true);

        $this->createIndex('ix-salon_service-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-salon_service-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey('fk-salon_service-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-salon_service-service_id', $this->tableName, 'service_id', '{{%service}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
