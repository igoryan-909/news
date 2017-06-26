<?php

namespace app\controllers;

use app\components\behaviors\PostBehavior;
use app\components\helpers\NotifyHelper;
use app\components\notify\NotifyUserSettings;
use app\models\Notify;
use app\models\PostTrack;
use app\models\UploadForm;
use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @var Post
     */
    protected $post;
    /**
     * @var NotifyUserSettings
     */
    protected $notifyUserSettings;


    /**
     * PostController constructor.
     * @param string $id
     * @param Module $module
     * @param NotifyUserSettings $notifyUserSettings
     * @param array $config
     */
    public function __construct($id, Module $module, NotifyUserSettings $notifyUserSettings, array $config = [])
    {
        $this->notifyUserSettings = $notifyUserSettings;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['index'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['create'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['update'],
                        'roleParams' => function ($rule) {
                            $this->findModel(Yii::$app->request->get('id'));
                            return ['post' => $this->post];
                        },
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['delete'],
                        'roleParams' => function ($rule) {
                            $this->findModel(Yii::$app->request->get('id'));
                            return ['post' => $this->post];
                        },
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

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            switch ($action->id) {
                case 'view' :
                    if (!$this->notifyUserSettings->activeBrowser()) {
                        break;
                    }
                    $this->findModel(Yii::$app->request->get('id'));
                    $postTrack = PostTrack::findOne([
                        'fk_user' => Yii::$app->user->id,
                        'fk_post' => $this->post->id_post,
                    ]);
                    if (is_null($postTrack)) {
                        $postTrack = new PostTrack();
                        $postTrack->setAttributes([
                            'fk_user' => Yii::$app->user->id,
                            'read_at' => time(),
                        ]);
                        $postTrack->link('fkPost', $this->post);
                    }
            }
            return true;
        }

        return false;
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        /** @var UploadForm $uploadForm */
        $uploadForm = Yii::$container->setSingleton(UploadForm::className())->get(UploadForm::className());
        if ($model->load(Yii::$app->request->post())) {
            $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');
            $model->attachBehavior('post', PostBehavior::className());
            if ($uploadForm->upload() && $model->save()) {
                return 1;
            }
        } elseif (Yii::$app->getRequest()->getIsAjax()) {
            return $this->renderAjax('create', [
                'model' => $model,
                'imageModel' => $uploadForm,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
            'imageModel' => $uploadForm,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        /** @var UploadForm $uploadForm */
        $uploadForm = Yii::$container->setSingleton(UploadForm::className())->get(UploadForm::className());
        if ($model->load(Yii::$app->request->post())) {
            $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');
            $model->attachBehavior('post', PostBehavior::className());
            if ($uploadForm->upload() && $model->save()) {
                return 1;
            }
        } elseif (Yii::$app->getRequest()->getIsAjax()) {
            return $this->renderAjax('update', [
                'model' => $model,
                'imageModel' => $uploadForm,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
            'imageModel' => $uploadForm,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (!is_null($this->post)) {
            return $this->post;
        }
        if (($this->post = Post::findOne($id)) !== null) {
            return $this->post;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
