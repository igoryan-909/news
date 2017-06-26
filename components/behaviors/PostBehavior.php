<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 20.06.2017
 * Time: 18:09
 */

namespace app\components\behaviors;


use app\components\helpers\NotifyHelper;
use app\models\base\Post;
use app\models\base\PostImage;
use app\models\Notify;
use app\models\UploadForm;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;
use yii\helpers\Json;
use Yii;
use yii\swiftmailer\Mailer;

/**
 * Class PostBehavior
 */
class PostBehavior extends Behavior
{
    /**
     * @var Post
     */
    public $owner;
    /**
     * @var UploadForm
     */
    protected $uploadForm;
    /**
     * @var Mailer
     */
    protected $mailer;


    public function __construct(UploadForm $uploadForm, array $config = [])
    {
        $this->mailer = Yii::$app->mailer;
        $this->uploadForm = $uploadForm;

        parent::__construct($config);
    }

    public function events()
    {
        return array_merge(parent::events(), [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
        ]);
    }

    public function afterInsert(AfterSaveEvent $event)
    {
        $this->notice();
        $this->saveImage();
    }

    public function afterUpdate(AfterSaveEvent $event)
    {
        $this->saveImage();
    }

    protected function saveImage()
    {
        if (empty($this->uploadForm->getFileNames())) {
            return;
        }
        $data = [
            'fields' => ['fk_post', 'path', 'thumb_path', 'created_at'],
            'values' => [],
        ];
        $this->deleteImages();
        foreach ($this->uploadForm->getFileNames() as $fileName) {
            $data['values'][] = [$this->owner->id_post, $fileName['full'], $fileName['thumb'], time()];
        }
        PostImage::getDb()
            ->createCommand()
            ->batchInsert(PostImage::tableName(), $data['fields'], $data['values'])
            ->execute();
    }

    protected function deleteImages()
    {
        /** @var PostImage[] $postImages */
        $postImages = $this->owner->getPostImages()->all();
        if (empty($postImages)) {
            return;
        }
        $path = \Yii::getAlias('@webroot' . \Yii::$app->params['uploadDir']) . DIRECTORY_SEPARATOR;
        foreach ($postImages as $postImage) {
            unlink($path . $postImage->path);
            unlink($path . $postImage->thumb_path);
        }
        PostImage::deleteAll(['fk_post' => $this->owner->id_post]);
    }

    protected function notice()
    {
        /** @var Notify[] $notifies */
        $notifies = Notify::findAll(['status' => 1, ['<>', 'fk_user', Yii::$app->user->id]]);
        foreach ($notifies as $notify) {
            switch ($notify->client) {
                case NotifyHelper::CLIENT_EMAIL :
                    $clientData = Json::decode($notify->client_data);
                    $this->mailer->compose()
                        ->setTextBody('Новый пост ' . $this->owner->title)
                        ->setTo([$clientData['email']])
                        ->setSubject(Yii::t('app', 'Новый пост'))
                        ->send();
                    break;
            }
        }
    }
}
