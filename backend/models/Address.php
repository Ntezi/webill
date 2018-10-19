<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/19/18
 * Time: 9:44 AM
 */

namespace backend\models;

use \common\models\Address as BaseAddress;
use yii\behaviors\BlameableBehavior;

class Address extends BaseAddress
{
    public function rules()
    {
        return [
            [['zip_code', 'prefecture', 'city', 'ward', 'town', 'district', 'street_number', 'building_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['zip_code', 'prefecture', 'city', 'ward', 'town', 'district', 'street_number', 'building_name'], 'string', 'max' => 255],
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
}