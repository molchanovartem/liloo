<?php

use yii\db\Migration;

/**
 * Class m180595_081962_tariff
 */
class m180595_081962_tariff extends Migration
{
    protected $tableName = '{{%tariff}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'type' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'quantity' => $this->integer(),
            'access' => $this->string()->notNull(),
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
