<?php

use yii\db\Migration;

/**
 * Class m180416_071052_user_file
 */
class m180416_071052_user_file extends Migration
{
    protected $tableName = '{{%user_file}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createIndex('ix-user_file-user_id', $this->tableName, 'user_id');
        $this->addForeignKey('fk-user_file-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
