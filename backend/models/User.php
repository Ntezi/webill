<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/16/18
 * Time: 10:50 AM
 */

namespace backend\models;

use common\helpers\EmailHelper;
use Yii;
use \common\models\User as BaseUser;
use yii\behaviors\BlameableBehavior;
/**
 * User model
 *
 * @property string $first_name
 * @property string $last_name
 * @property int $created_by
 * @property int $updated_by
 * @property int $role 0:admin; 1:consumer
 * @property string $password
 * @property string $confirm_password
 * @property int $meter_id
 */
class User extends BaseUser
{
    const ROLE = 0;

    public $password;
    public $confirm_password;

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['role', 'default', 'value' => self::ROLE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'role'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'first_name', 'last_name'], 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>Yii::t('app', "Passwords don't match")],
        ];
    }

    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE, 'role' => self::ROLE]);
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

    public static function registeredMessage($email, $password, $role)
    {
        $subject = 'Webill Admin';

        $body = "Your account was successfully created <br/>";
        $body .= "Please use this password: <b>" . $password . " </b>";

        if ($role == Yii::$app->params['consumer_role']){
            $body .=" to login at <a href=". Yii::$app->params['client_url'] .">Webill</a> " . "<br/>";
        }

        if ($role == Yii::$app->params['admin_role']){
            $body .=" to login at <a href=". Yii::$app->params['admin_url'] .">Webill Admin</a>  as an admin user. " . "<br/>";
        }

        $body .="You may change it later after successfully logged in";

        EmailHelper::sendEmail($email, $subject , $body);
    }
}
