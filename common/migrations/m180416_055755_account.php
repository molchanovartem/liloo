<?php

use yii\db\Migration;

/**
 * Class m180511_055755_account
 */
class m180416_055755_account extends Migration
{
    protected $tableName = '{{%account}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()
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
