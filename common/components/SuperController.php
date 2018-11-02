<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/31/18
 * Time: 12:07 AM
 */

namespace common\components;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
class SuperController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'index',
                    'create',
                    'update',
                    'view',
                    'delete',
                    'remove',
                    'submit',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'create',
                            'update',
                            'view',
                            'delete',
                            'remove',
                            'submit',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'logout' => ['POST'],
                    'remove' => ['POST'],
                    'submit' => ['POST'],
                ],
            ],
        ];
    }
}