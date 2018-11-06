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
use frontend\models\Bill as BaseBill;

class Bill extends BaseBill
{

    public function readBillQRCode()
    {
        $path = Yii::getAlias('@frontend') . '/web/uploads/bills/' . $this->user_id . '/' . $this->id . '/' . $this->image_file;
        Yii::warning('bills path: ' . $path);
        return QRCodeHelper::ReadQRCode($path);
    }

    //Billing Formula
    //[consumption *unit_price + tax] - discount where
    //consumption = current_reading-previous_reading
    public function calculateBill()
    {
        $bill_info = BillInfo::findOne(1);
        $consumption = $this->current_reading - $this->previous_reading;
        return ($consumption * $bill_info->unit_price + $bill_info->unit_price + 0.08) - $bill_info->discount;

    }

    public function getConsumerEmail()
    {
        $user = User::findOne(['id' => $this->user_id]);
        if (empty($user))
            Yii::warning('email : ' . $user->email);
            return $user->email;
    }
}