<?php

namespace app\controllers;

use app\components\behaviors\PostBehavior;
use app\models\Post;
use Yii;
use app\models\PostTrack;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * PostTrackController implements the CRUD actions for PostTrack model.
 */
class PostTrackController extends Controller
{
    /**
     * @inheritdoc
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
            'post' => PostBehavior::className(),
        ];
    }

    /**
     * @param $id
     */
    public function actionCreate($id)
    {
        $model = new PostTrack();
        $model->setAttributes([
            'fk_user' => Yii::$app->user->id,
            'fk_post' => $id,
            'read_at' => time(),
        ]);

        $model->save();
    }
}
