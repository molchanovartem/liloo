<?php

use yii\db\Migration;

/**
 * Class m180416_071228_service
 */
class m180416_071228_service extends Migration
{
    protected $tableName = '{{%service}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'is_group' => $this->integer()->notNull(),
            'specialization_id' => $this->integer(),
            'common_service_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'price' => $this->decimal('18', '2'),
            'duration' => $this->integer()
        ]);

        $this->createIndex('ix-service-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-service-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-service-specialization_id', $this->tableName, 'specialization_id');
        $this->addForeignKey('fk-service-specialization_id', $this->tableName, 'specialization_id', '{{%specialization}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-service-common_service_id', $this->tableName, 'common_service_id');
        $this->addForeignKey('fk-service-common_service_id', $this->tableName, 'common_service_id', '{{%common_service}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
