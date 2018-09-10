<?php

namespace admin\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Class User
 * @package admin\models
 */
class User extends ActiveRecord
{
    const ROLE_SUPERADMIN = 0;
    const ROLE_ADMIN = 1;

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
     * @return string
     */
    public static function tableName()
    {
        return '{{%admin_user}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['login', 'password', 'role',], 'required'],
            [['login', 'password'], 'string', 'max' => 255],
            [['login'], 'unique'],
        ];
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return [
            self::ROLE_SUPERADMIN => 'Суперадмин',
            self::ROLE_ADMIN => 'Админ',
        ];
    }

    /**
     * @param $role
     * @return mixed
     */
    public function getRole($role)
    {
        return $this->getRoles()[$role];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'role' => 'Роль',
        ];
    }

    /**
     * @param $userId
     * @return bool
     */
    public static function isUserAdmin($userId)
    {
        if (static::findOne(['id' => $userId, 'role' => self::ROLE_ADMIN])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return User|null
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @param $login
     * @return User|null
     */
    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (isset($this->dirtyAttributes['password'])) {
            $this::setPassword($this->dirtyAttributes['password']);
        }

        return true;
    }
}
