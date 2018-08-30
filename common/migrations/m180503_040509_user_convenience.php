<?php

use yii\db\Migration;

/**
 * Class m180503_040509_user_convenience
 */
class m180503_040509_user_convenience extends Migration
{
    private $tableName = '{{%user_convenience}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'user_id' => $this->integer(),
            'convenience_id' => $this->integer()
        ]);

        $this->addPrimaryKey('', $this->tableName, ['user_id', 'convenience_id']);
        $this->addForeignKey('fk-user_convenience-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-user_convenience-convenience_id', $this->tableName, 'convenience_id', '{{%convenience}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
