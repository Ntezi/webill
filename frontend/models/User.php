<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/23/18
 * Time: 9:47 AM
 */

namespace frontend\models;

use \backend\models\User as BaseUser;

class User extends BaseUser
{
    const ROLE = 1;

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE, 'role' => self::ROLE]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE, 'role' => self::ROLE]);
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

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE, 'role' => self::ROLE]);
    }
}