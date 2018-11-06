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
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            [['email', 'password'], 'validateConsumer'],
        ];
    }

    protected function getUser()
    {
        if ($this->_user === null) {
//            $this->_user = User::findByUsername($this->username);
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    public function validateConsumer($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user && $user->role != 1) {
                $this->addError($attribute, 'You are not allowed to access the client site!');
            }
        }
    }
}