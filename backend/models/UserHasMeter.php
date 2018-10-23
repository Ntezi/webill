<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/23/18
 * Time: 11:18 AM
 */

namespace backend\models;

use \common\models\UserHasMeter as BaseUserHasMeter;
use yii\behaviors\BlameableBehavior;

class UserHasMeter extends BaseUserHasMeter
{
    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'started_at',
                'updatedByAttribute' => 'ended_at',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'meter_id'], 'required'],
            [['user_id', 'meter_id', 'status'], 'integer'],
            [['started_at', 'ended_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['meter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Meter::className(), 'targetAttribute' => ['meter_id' => 'id']],
        ];
    }
}