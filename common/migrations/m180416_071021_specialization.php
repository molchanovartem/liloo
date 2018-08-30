<?php

use yii\db\Migration;

/**
 * Class m180423_041851_spezialization
 */
class m180416_071021_specialization extends Migration
{
    protected $tableName = '{{%specialization}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(1000)
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
