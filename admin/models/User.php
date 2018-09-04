<?php

namespace admin\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $registration_date
 * @property double $balance
 */
class User extends ActiveRecord {

    const ROLE_ADMIN = 'admin';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%admin_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['login', 'password', 'role',], 'required'],
            [['login', 'password'], 'string', 'max' => 255],
            [['login'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'role' => 'Роль',
        ];
    }

    public static function isUserAdmin($userId) {
        if (static::findOne(['id' => $userId, 'role' => self::ROLE_ADMIN])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByLogin($login) {
        return static::findOne(['login' => $login]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->password === md5($password);
    }

    /**
     * @param $password
     */
    public function setPassword($password) {
        $this->password = md5($password);
    }

    public function beforeSave($insert) {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (isset($this->dirtyAttributes['password'])) {
            $this::setPassword($this->dirtyAttributes['password']);
        }

        return true;
    }

}
