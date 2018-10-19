<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/19/18
 * Time: 3:12 PM
 */

namespace backend\models;

use \common\models\Meter as BaseMeter;
use yii\behaviors\BlameableBehavior;

class Meter extends BaseMeter
{
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

    public function rules()
    {
        return [
            [['address_id', 'qr_code'], 'required'],
            [['address_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['latitude', 'longitude', 'reading'], 'number'],
            [['created_at', 'update_at'], 'safe'],
            [['serial_number', 'qr_code'], 'string', 'max' => 255],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
        ];
    }

}