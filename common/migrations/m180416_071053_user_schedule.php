<?php

use yii\db\Migration;

/**
 * Class m180416_071053_user_schedule
 */
class m180416_071053_user_schedule extends Migration
{
    protected $tableName = '{{%user_schedule}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'start_date' => $this->dateTime(),
            'end_date' => $this->dateTime()
        ]);

        $this->createIndex('ix-user_schedule-user_id', $this->tableName, 'user_Id');
        $this->addForeignKey('fk-user_schedule-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
