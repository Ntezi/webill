<?php

namespace frontend\controllers;

use common\components\SuperController;
use frontend\models\User;
use Yii;
use frontend\models\Bill;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * BillController implements the CRUD actions for Bill model.
 */
class BillController extends SuperController
{
    /**
     * Lists all Bill models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Bill::find()
                ->where(['user_id' => Yii::$app->user->identity->getId()]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bill model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->redirect(['index']);
    }

    /**
     * Creates a new Bill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bill();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = $model->getDb()->beginTransaction();
            try {

                Yii::warning('Before upload');
                $meter = User::getConsumerCurrentMeter(Yii::$app->user->identity->id);
                if (!empty($meter)) {
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->previous_reading = $meter->reading;
                    $model->verified_by_user = Yii::$app->params['verified_no'];
                    $model->verified_by_admin = Yii::$app->params['verified_no'];
                    $model->paid_flag = null;
                    if ($model->save()) {
                        $uploaded_file = UploadedFile::getInstance($model, 'image');
                        if ($model->uploadImage($uploaded_file)) {
                            Yii::$app->session->setFlash("success", Yii::t('app', 'Successfully uploaded'));
                            $transaction->commit();
                            return $this->redirect(['index']);
                        } else {
                            $transaction->rollBack();
                            Yii::$app->session->setFlash("warning", Yii::t('app', 'Problem occurred while uploading'));
                        }
                    }
                    Yii::error(print_r($model->getErrors(), true));
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash("warning", Yii::t('app', 'No meter assigned to you!'));
                }

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Bill model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = $model->getDb()->beginTransaction();
            try {

                Yii::warning('Before upload');
                $meter = User::getConsumerCurrentMeter(Yii::$app->user->identity->id);
                if (!empty($meter)) {
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->previous_reading = $meter->reading;
                    $model->verified_by_user = Yii::$app->params['verified_no'];
                    $model->verified_by_admin = Yii::$app->params['verified_no'];
                    $model->paid_flag = null;
                    if ($model->save()) {
                        $uploaded_file = UploadedFile::getInstance($model, 'image');
                        if ($model->uploadImage($uploaded_file)) {
                            Yii::$app->session->setFlash("success", Yii::t('app', 'Successfully uploaded'));
                            $transaction->commit();
                            return $this->redirect(['index']);
                        } else {
                            $transaction->rollBack();
                            Yii::$app->session->setFlash("warning", Yii::t('app', 'Problem occurred while uploading'));
                        }
                    }
                    Yii::error(print_r($model->getErrors(), true));
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash("warning", Yii::t('app', 'No meter assigned to you!'));
                }

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Bill model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

    public function actionSubmit($id)
    {
        $model = $this->findModel($id);
        $model->verified_by_user = Yii::$app->params['verified_yes'];
        $model->save();

        return $this->redirect(['index']);
    }
}
