<?php

use yii\db\Migration;

/**
 * Class m180423_041905_user_specialization
 */
class m180416_071030_user_specialization extends Migration
{
    protected $tableName = '{{%user_specialization}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'user_id' => $this->integer()->notNull(),
            'specialization_id' => $this->integer()->notNull()
        ]);

        $this->createIndex('ix-user_specialization-user_id-specialization_id', $this->tableName, ['user_id', 'specialization_id']);
        $this->addForeignKey('fk-user_specialization-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_specialization-specialization_id', $this->tableName, 'specialization_id', '{{%specialization}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
