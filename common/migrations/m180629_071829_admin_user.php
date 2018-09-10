<?php

use yii\db\Migration;

/**
 * Class m180416_071029_admin_user
 */
class m180416_071029_admin_user extends Migration
{
    protected $tableName = '{{%admin_user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'role' => $this->string()->notNull(),
            'create_time' => $this->dateTime(),
            'updated_time' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
