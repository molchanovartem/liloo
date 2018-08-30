<?php

use yii\db\Migration;

/**
 * Class m180507_092318_portfolio_image
 */
class m180507_092318_portfolio_image extends Migration
{
    private $tableName = '{{%portfolio_image}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'portfolio_id' => $this->integer()->notNull(),
            'sort' => $this->integer()->notNull(),
            'file' => $this->string(),
            'name' => $this->string(),
            'description' => $this->string(500),
        ]);

        $this->createIndex('ix-portfolio_image-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-portfolio_image-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-portfolio_image-portfolio_id', $this->tableName, 'portfolio_id');
        $this->addForeignKey('fk-portfolio_image-portfolio_id', $this->tableName, 'portfolio_id', '{{%portfolio}}', 'id', 'NO ACTION', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
