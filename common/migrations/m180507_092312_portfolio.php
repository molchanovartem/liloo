<?php

use yii\db\Migration;

/**
 * Class m180507_092312_portfolio
 */
class m180507_092312_portfolio extends Migration
{
    private $tableName = '{{%portfolio}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'salon_id' => $this->integer(),
            'service_id' => $this->integer(),
            'sort' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(1000),
            'image' => $this->string()
        ]);

        $this->execute("ALTER TABLE {$this->tableName} ADD `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `image`;");
        $this->execute("ALTER TABLE {$this->tableName} ADD `update_time` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `create_time`;");

        $this->createIndex('ix-portfolio-account_id', $this->tableName, 'account_id');
        $this->addForeignKey('fk-portfolio-account_id', $this->tableName, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('ix-portfolio-salon_id', $this->tableName, 'salon_id');
        $this->createIndex('ix-portfolio-service_id', $this->tableName, 'service_id');
        $this->addForeignKey('fk-portfolio-salon_id', $this->tableName, 'salon_id', '{{%salon}}', 'id', 'NO ACTION', 'CASCADE');
        $this->addForeignKey('fk-portfolio-service_id', $this->tableName, 'service_id', '{{%service}}', 'id', 'NO ACTION', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
