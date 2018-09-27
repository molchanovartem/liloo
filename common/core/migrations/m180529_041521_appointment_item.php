<?php

use yii\db\Migration;

/**
 * Class m180529_041521_appointment_item
 */
class m180529_041521_appointment_item extends Migration
{
    protected $tableName = '{{%appointment_item}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'appointment_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'service_name' => $this->string()->notNull(),
            'service_price' => $this->decimal(15, 2)->notNull(),
            'service_duration' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull()
        ]);

        $this->createIndex('ix-appointment_item-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-appointment_item-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-appointment_item-appointment_id', $this->tableName, 'appointment_id');
        $this->addForeignKey('fk-appointment_item-appointment_id', $this->tableName, 'appointment_id', '{{%appointment}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-appointment_item-service_id', $this->tableName, 'service_id');
        $this->addForeignKey('fk-appointment_item-service_id', $this->tableName, 'service_id', '{{%service}}', 'id', 'NO ACTION', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
