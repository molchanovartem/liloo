<?php

use yii\db\Migration;

/**
 * Class m180503_040516_salon_convenience
 */
class m180503_040516_salon_convenience extends Migration
{
    private $tableName = '{{%salon_convenience}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'salon_id' => $this->integer()->notNull(),
            'convenience_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('ix-salon_convenience-account_id', $this->tableName, 'account_id');
        $this->createIndex('ix-salon_convenience-salon_id-convenience_id', $this->tableName, ['salon_id', 'convenience_id'], true);

        $this->addForeignKey('fk-salon_convenience-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-salon_convenience-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-salon_convenience-convenience_id', $this->tableName, 'convenience_id', '{{%convenience}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
