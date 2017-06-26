<?php

namespace app\controllers;

use Yii;
use app\models\Notify;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotifyController implements the CRUD actions for Notify model.
 */
class NotifyController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @param $id
     * @return string
     */
    public function actionUpdateStatus($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(Notify::SCENARIO_STATUS);
        $this->checkAccess($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 1;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Notify model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notify the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notify::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function checkAccess(Notify $model)
    {
        if (($model->fk_user !== Yii::$app->user->id
            && !Yii::$app->user->can('admin')) || Yii::$app->user->getIsGuest()) {
            throw new ForbiddenHttpException(Yii::t('app', 'Доступ запрещен.'));
        }
    }
}
