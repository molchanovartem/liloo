<?php

use yii\db\Migration;

/**
 * Class m180529_041521_admin_user_interaction
 */
class m180529_041521_admin_user_interaction extends Migration
{
    protected $tableName = '{{%admin_user_interaction}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'comment' => $this->string()->notNull(),
            'created_time' => $this->dateTime(),
            'updated_time' => $this->dateTime(),
        ]);

        $this->createIndex('ix-user-user_id', $this->tableName, 'user_id');
        $this->addForeignKey('fk-user-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
