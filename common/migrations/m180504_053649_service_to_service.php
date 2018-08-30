<?php

use yii\db\Migration;

/**
 * Class m180504_053649_service_to_service
 */
class m180504_053649_service_to_service extends Migration
{
    private $tableName = '{{%service_to_service}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'parent_id' => $this->integer(),
            'service_id' => $this->integer()
        ]);

        $this->addPrimaryKey('', $this->tableName, ['parent_id', 'service_id']);
        $this->addForeignKey('fk-service_to_service-parent_id', $this->tableName, 'parent_id', '{{%service}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-service_to_service-service_id', $this->tableName, 'service_id', '{{%service}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
