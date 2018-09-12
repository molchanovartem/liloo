<?php

use yii\db\Migration;

/**
 * Class m180595_081964_tariff_price
 */
class m180595_081964_tariff_price extends Migration
{
    protected $tableName = '{{%tariff_price}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'tariff_id' => $this->integer()->notNull(),
            'price' => $this->decimal(18, 2)->notNull(),
            'days' => $this->integer()->notNull(),
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
