<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\UserController as BaseUserController;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseUserController
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->password != null) {
                $model->setPassword($model->password);
            }
            $model->save();
            Yii::warning($model->errors);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
