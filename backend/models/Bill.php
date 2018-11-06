<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/26/18
 * Time: 4:02 PM
 */

namespace backend\models;

use common\helpers\QRCodeHelper;
use Yii;
use common\models\Bill as BaseBill;
use yii\behaviors\BlameableBehavior;

class Bill extends BaseBill
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

    public function readBillQRCode()
    {
        $path = Yii::getAlias('@frontend') . '/web/uploads/bills/' . $this->user_id. '/'. $this->image_file;
        Yii::warning('bills path: ' . $path);
        return QRCodeHelper::ReadQRCode($path);
    }
}