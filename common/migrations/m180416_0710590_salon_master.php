<?php

use yii\db\Migration;

/**
 * Class m180416_0710590_salon_master
 */
class m180416_0710590_salon_master extends Migration
{
    protected $tableName = '{{%salon_master}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'salon_id' => $this->integer()->notNull(),
            'master_id' => $this->integer()->notNull()
        ]);

        $this->createIndex('ix-salon_master-master_id-salon_id', $this->tableName, ['master_id', 'salon_id'], true);

        $this->createIndex('ix-salon_master-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-salon_master-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey('fk-salon_master-master_id', $this->tableName, 'master_id', '{{%master}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-salon_master-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
