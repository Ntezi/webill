<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/16/18
 * Time: 10:55 AM
 */

namespace console\models;

use common\helpers\EmailHelper;
use Yii;
use \backend\models\User as BaseUser;

class User extends BaseUser
{

    public static function registerAdmin($email)
    {
        $admin = new User();
        $admin->email = $email;
        $password = Yii::$app->security->generateRandomString(6);
        $admin->setPassword($password);
        $admin->status = User::STATUS_ACTIVE;
        $admin->role = User::ROLE;

        if ($admin->save()) {
            echo 'New admin: ' . $email . ' created!' . "\n";

            $subject = 'Webill Admin';
            $body = "Please use this password: <b>" . $password . " </b> to login at Webill as an Admin.\n
            You may change it later after successfully logged in";

            EmailHelper::sendEmail($email, $subject , $body);
        } else {

            echo 'Failed to create admin account: ' . $email . "\n";
            print_r($admin->getErrors());
        }
    }
}