<?php

namespace backend\controllers;

use backend\models\Address;
use backend\models\Meter;
use backend\models\UserHasMeter;
use Yii;
use backend\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConsumerController implements the CRUD actions for User model.
 */
class ConsumerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['role' => Yii::$app->params['consumer_role'], 'status' => User::STATUS_ACTIVE]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        $address_model = new Address();
        $addresses = Address::find()->all();
        if ($model->load(Yii::$app->request->post())) {

            $transaction = $model->getDb()->beginTransaction();
            try {

                $model->save();
                $post = Yii::$app->request->post('Address');

                if (!empty($post['address'])) {
                    $meter = Meter::getMeter($post);
                    $user_has_meter = new UserHasMeter();
                    $user_has_meter->user_id = $model->id;
                    $user_has_meter->meter_id = $meter->id;
                    $user_has_meter->started_at = date("Y-m-d H:i:s");
                    $user_has_meter->save();

                    $error = $user_has_meter->getErrors();
                    if (!empty($error)) {
                        Yii::error(print_r($error, true));

                        if (!empty($error ['meter_id'][0]) && $error ['meter_id'][0] == 'This meter has already been taken'){
                            Yii::$app->getSession()->setFlash("warning", Yii::t('app', 'This meter has already been taken'));
                            Yii::warning($error ['meter_id'][0]);
                            Yii::warning(Yii::$app->session->getFlash("warning"));
                        }

                    }
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'addresses' => $addresses,
            'address_model' => $address_model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $address_model = new Address();
        $addresses = Address::find()->all();
        if ($model->load(Yii::$app->request->post())) {

            $transaction = $model->getDb()->beginTransaction();
            try {

                $model->save();
                $post = Yii::$app->request->post('Address');

                if (!empty($post['address'])) {
                    $meter = Meter::getMeter($post);
                    $user_has_meter = new UserHasMeter();
                    $user_has_meter->user_id = $model->id;
                    $user_has_meter->meter_id = $meter->id;
                    $user_has_meter->started_at = date("Y-m-d H:i:s");
                    $user_has_meter->save();

                    $error = $user_has_meter->getErrors();
                    if (!empty($error)) {
                        Yii::error(print_r($error, true));
                        Yii::warning($error ['meter_id'][0]);
                    }
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'addresses' => $addresses,
            'address_model' => $address_model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = User::STATUS_DELETED;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
