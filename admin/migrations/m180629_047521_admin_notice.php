<?php

use yii\db\Migration;

/**
 * Class m180529_041521_admin_notice
 */
class m180529_041521_admin_notice extends Migration
{
    protected $tableName = '{{%admin_notice}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
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
