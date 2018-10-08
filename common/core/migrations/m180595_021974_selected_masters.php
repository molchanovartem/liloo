<?php

use yii\db\Migration;

/**
 * Class m180595_021974_selected_masters
 */
class m180595_021974_selected_masters extends Migration
{
    protected $tableName = '{{%selected_masters}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'executor_id' => $this->integer(),
            'siSalon' => $this->integer(),
        ]);

        $this->createIndex('ix-selected_masters-user_id', $this->tableName, 'user_id');
        $this->addForeignKey('fk-selected_masters-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-selected_masters-salon_id', $this->tableName, 'salon_id');
        $this->addForeignKey('fk-selected_masters-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
