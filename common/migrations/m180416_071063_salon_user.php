<?php

use yii\db\Migration;

/**
 * Class m180426_045631_salon_user
 */
class m180416_071063_salon_user extends Migration
{
    protected $tableName = '{{%salon_user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'salon_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('ix-salon_user-account_id', $this->tableName,'account_id');
        $this->createIndex('ix-salon_user-user_id', $this->tableName, ['salon_id', 'user_id'], true);

        $this->addForeignKey('fk-salon_user-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-salon_user-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-salon_user-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
