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
            'country_id' => $this->integer(),
            'city_id' => $this->integer(),
            'surname' => $this->string(),
            'name' => $this->string()->notNull(),
            'patronymic' => $this->string(),
            'date_birth' => $this->date(),
            'avatar' => $this->string(),
            'description' => $this->text(),
            'phone' => $this->string(15)->notNull(),
            'address' => $this->string(),
            'latitude' => $this->decimal(9,6),
            'longitude' => $this->decimal(9,6),
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
