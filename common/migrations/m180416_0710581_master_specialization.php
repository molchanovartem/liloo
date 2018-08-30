<?php

use yii\db\Migration;

/**
 * Class m180416_0710581_master_specialization
 */
class m180416_0710581_master_specialization extends Migration
{
    protected $tableName = '{{%master_specialization}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'master_id' => $this->integer()->notNull(),
            'specialization_id' => $this->integer()->notNull()
        ]);

        $this->createIndex('ix-master_specialization-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-master_specialization-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-master_specialization-master_id-specialization_id', $this->tableName, ['master_id', 'specialization_id'], true);
        $this->addForeignKey('fk-master_specialization-master_id', $this->tableName, 'master_id', '{{%master}}', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey('fk-master_specialization-specialization_id', $this->tableName, 'specialization_id', '{{%specialization}}', 'id', 'NO ACTION', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
