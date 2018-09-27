<?php

use yii\db\Migration;

/**
 * Class m180416_071029_user
 */
class m180416_071029_user extends Migration
{
    protected $tableName = '{{%user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'login' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'token' => $this->string()->notNull(),
            'refresh_token' => $this->string()->notNull()
        ]);

        $this->createIndex('ix-user-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-user-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
