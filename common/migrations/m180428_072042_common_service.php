<?php

use yii\db\Migration;

/**
 * Class m180428_072042_common_service
 */
class m180428_072042_common_service extends Migration
{
    protected $tableName = '{{%common_service}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'specialization_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'price' => $this->decimal('18', '2'),
            'duration' => $this->integer(),
        ]);

        $this->createIndex('ix-common_service-specialization_id', $this->tableName, 'specialization_id');
        $this->addForeignKey('fk-common_service-specialization_id', $this->tableName, 'specialization_id', '{{%specialization}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
