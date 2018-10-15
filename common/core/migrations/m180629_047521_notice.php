<?php

use yii\db\Migration;

/**
 * Class m180529_041521_notice
 */
class m180529_041521_notice extends Migration
{
    protected $tableName = '{{%notice}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
        ]);

        $this->execute("ALTER TABLE {$this->tableName} ADD `data` JSON NULL AFTER `text`;");
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
