<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 11/6/18
 * Time: 11:50 AM
 */

namespace common\helpers;

use Yii;
use Zxing\QrReader;

class QRCodeHelper
{
    public static function ReadQRCode($path)
    {
        $qrcode = new QrReader($path);
        $text = $qrcode->text(); //return decoded text from QR Code
        Yii::warning('text: ' . $text);
        return $text;
    }
}