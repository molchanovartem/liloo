<?php

use yii\db\Migration;

/**
 * Class m180503_040500_convenience
 */
class m180503_040500_convenience extends Migration
{
    protected $tableName = '{{%convenience}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(500)
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
