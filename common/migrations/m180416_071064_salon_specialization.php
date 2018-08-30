<?php

use yii\db\Migration;

/**
 * Class m180426_045955_salon_specialization
 */
class m180416_071064_salon_specialization extends Migration
{
    protected $tableName = '{{%salon_specialization}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'salon_id' => $this->integer()->notNull(),
            'specialization_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('ix-salon_specialization-account_id', $this->tableName, 'account_id');
        $this->createIndex('ix-salon_specialization-salon_id-specialization_id', $this->tableName, ['salon_id', 'specialization_id'], true);

        $this->addForeignKey('fk-salon_specialization-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-salon_specialization-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-salon_specialization-specialization_id', $this->tableName, 'specialization_id', '{{%specialization}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
