<?php

use yii\db\Migration;

/**
 * Class m180416_071001_country
 */
class m180416_071001_country extends Migration
{
    protected $tableName = '{{%country}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'currency_code' => $this->integer(3)->notNull(),
            'currency_string_code' => $this->char(3)->notNull(),
            'phone_code' => $this->integer()->notNull()
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
