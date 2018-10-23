<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/16/18
 * Time: 11:54 AM
 */

namespace frontend\models;

use common\models\LoginForm as BaseLoginForm;

class LoginForm extends BaseLoginForm
{
    public $username;
    public $password;
    private $_user;


    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}