<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/16/18
 * Time: 10:50 AM
 */

namespace backend\models;

use \common\models\User as BaseUser;

class User extends BaseUser
{
    const ROLE = 0;

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['role', 'default', 'value' => self::ROLE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE, 'role' => self::ROLE]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE, 'role' => self::ROLE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE, 'role' => self::ROLE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
            'role' => self::ROLE,
        ]);
    }
}