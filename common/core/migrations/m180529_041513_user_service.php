<?php

use yii\db\Migration;

/**
 * Class m180529_041513_user_service
 */
class m180529_041513_user_service extends Migration
{
    public $tableName = '{{%user_service}}';

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
            'service_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('ix-user_service-account_id', $this->tableName, 'account_id');
        $this->createIndex('ix-user_service-salon_id-user_id-service_id', $this->tableName, ['salon_id', 'user_id', 'service_id'], true);

        $this->addForeignKey('fk-user_service-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_service-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_service-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_service-service_id', $this->tableName, 'service_id', '{{%service}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
