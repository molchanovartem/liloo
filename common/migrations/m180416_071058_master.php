<?php

use yii\db\Migration;

/**
 * Class m180416_071058_master
 */
class m180416_071058_master extends Migration
{
    protected $tableName = '{{%master}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'surname' => $this->string(),
            'name' => $this->string()->notNull(),
            'patronymic' => $this->string(),
            'date_birth' => $this->date()
        ]);

        $this->createIndex('ix-master-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-master-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');


        $this->createIndex('ix-master-user_id', $this->tableName, 'user_id');
        $this->addForeignKey('fk-master-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
