<?php

use yii\db\Migration;

/**
 * Class m180416_071042_user_profile
 */
class m180416_071042_user_profile extends Migration
{
    protected $tableName = '{{%user_profile}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'surname' => $this->string(),
            'name' => $this->string()->notNull(),
            'patronymic' => $this->string(),
            'date_birth' => $this->date(),
            'avatar' => $this->string(),
            'description' => $this->text(),
            'phone' => $this->string(15)->notNull(),
            'city_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'address' => $this->string()->notNull(),
        ]);

        $this->createIndex('ix-user_profile-user_id', $this->tableName,'user_id');
        $this->addForeignKey('fk-user_profile-user_id', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
