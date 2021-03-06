<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/26/18
 * Time: 3:52 PM
 */

namespace frontend\models;

use backend\models\BillInfo;
use common\helpers\QRCodeHelper;
use Yii;
use common\helpers\UploadHelper;
use common\models\Bill as BaseBill;
use yii\behaviors\BlameableBehavior;

class Bill extends BaseBill
{
    public $image;

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
            [['user_id'], 'required'],
            [['user_id', 'bill_info_id', 'verified_by_user', 'verified_by_admin', 'created_by', 'updated_by', 'paid_flag'], 'integer'],
            [['previous_reading', 'total_amount'], 'number'],
            [['created_at', 'updated_at', 'deadline'], 'safe'],
            [['image_file', 'bill_file_path'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['bill_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => BillInfo::className(), 'targetAttribute' => ['bill_info_id' => 'id']],

            [['image'], 'safe'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxSize' => 1024 * 1024],
        ];
    }

    public function beforeValidate()
    {
        $this->image = preg_replace('/\s+/', '', $this->image);

        return parent::beforeValidate();
    }

    public function uploadImage($uploaded_file)
    {
        $file_name = rand() . rand() . date("Ymdhis") . '.' . $uploaded_file->extension;

        Yii::warning('file name: ' . $file_name);
        $path = Yii::getAlias('@frontend') . '/web/uploads/bills/';
        $file_dir = $path . Yii::$app->user->identity->id . '/' . $this->id . '/';

        Yii::warning('file dir: ' . $file_name);
        if (UploadHelper::upload($uploaded_file, $this, 'image_file', $file_name, $file_dir)) {
            Yii::warning('After: ' . $file_name);
            return true;
        } else {
            Yii::warning('fail: ' . $file_name);
            return false;
        }
    }

    public function getFlagLabel()
    {
        $label = Yii::t('app', 'Not set');
        if ($this->paid_flag == Yii::$app->params['not_paid_bill_flag']) {
            $label = Yii::t('app', 'Not paid');
        } elseif ($this->paid_flag == Yii::$app->params['paid_bill_flag']) {
            $label = Yii::t('app', 'Paid');
        } elseif ($this->paid_flag == Yii::$app->params['pending_bill_flag']) {
            $label = Yii::t('app', 'Pending');
        }

        return $label;
    }

    public function getImagePath()
    {
        $image = $this->user_id . '/' . $this->id . '/' . $this->image_file;
        return Yii::$app->params['frontend_uploads'] . 'bills/' . $image;
    }

    public function getImageAbsolutePath()
    {
        $image = $this->user_id . '/' . $this->id . '/' . $this->image_file;
        return Yii::getAlias('@frontend') . '/web/uploads/bills/' . $image;
    }

    public function readBillQRCode()
    {
        Yii::warning('bills path: ' . $this->getImagePath());
        return QRCodeHelper::ReadQRCode($this->getImagePath());
    }

    public function getMeterCurrentReading()
    {
        Yii::warning('getImageAbsolutePath: ' . $this->getImageAbsolutePath());
        return UploadHelper::getReadImage($this->getImageAbsolutePath());
    }

    public function saveMeterReading()
    {
        //Read image with OCR
        $current_reading = $this->getMeterCurrentReading();
        if ($current_reading != null) {
            $this->current_reading = $current_reading;
            $this->save();
        }
    }

    public function checkCurrentReading($current_reading)
    {
        if ($current_reading != null) {
            $this->current_reading = (int)$current_reading;
            if ($this->current_reading > $this->previous_reading) {
                return true;
            } else {
                return false;
            }
        }
    }
}