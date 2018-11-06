<?php

namespace backend\controllers;

use backend\models\Bill;
use backend\models\Meter;
use backend\models\User;
use Yii;
use common\components\SuperController;
use yii\web\NotFoundHttpException;

class BillController extends SuperController
{
    public function actionIndex($id)
    {
        $bill = $this->findModel($id);

        if (!empty($bill)) {

            $meter = User::getConsumerCurrentMeter($bill->user_id);

            $bill_qr = $bill->readBillQRCode();

            if ($bill_qr != null) {
                Yii::$app->session->setFlash("success", Yii::t('app', $bill_qr));
            }

//            if (!empty($meter)) {
//
//                $bill_qr = $bill->readBillQRCode();
//                $meter_qr = Meter::readMeterQRCode($meter);
//
//
//                if ($meter_qr != null && $bill_qr != null) {
//                    if ($meter_qr == $bill_qr) {
//                        Yii::$app->session->setFlash("success", Yii::t('app', 'Successfully Matched '));
//                    } else {
//                        Yii::$app->session->setFlash("warning", Yii::t('app', 'Not Matched '));
//                    }
//                }
//            }

            return $this->redirect(['site/index']);
        }

    }

    /**
     * Finds the Bill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bill::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
