<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/16/18
 * Time: 10:55 AM
 */

namespace console\models;

use common\helpers\EmailHelper;
use yii\helpers\Url;
use Yii;
use \backend\models\User as BaseUser;

class User extends BaseUser
{
    const ROLE = 0;

    public static function registerAdmin($email)
    {
        $admin = new User();
        $admin->email = $email;
        $admin->username = $email;
        $password = Yii::$app->security->generateRandomString(6);
        $admin->setPassword($password);
        $admin->status = User::STATUS_ACTIVE;
        $admin->role = User::ROLE;

        if ($admin->save()) {
            echo 'New admin: ' . $email . ' created!' . "\n";

            User::registeredMessage($email, $password, $admin->role);
        } else {

            echo 'Failed to create admin account: ' . $email . "\n";
            print_r($admin->getErrors());
        }
    }
}