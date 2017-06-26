<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 21.06.2017
 * Time: 23:57
 */

namespace app\components\behaviors;


use app\components\notify\NotifyUserSettings;
use app\models\Post;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\helpers\Json;
use yii\web\Application;
use Yii;

class NoticeAlertBehavior extends Behavior
{
    /**
     * @var NotifyUserSettings
     */
    protected $notifyUserSettings;


    public function __construct(NotifyUserSettings $notifyUserSettings, array $config = [])
    {
        $this->notifyUserSettings = $notifyUserSettings;

        parent::__construct($config);
    }

    public function events()
    {
        return array_merge(parent::events(), [
            Application::EVENT_BEFORE_ACTION => 'beforeAction',
            Application::EVENT_AFTER_ACTION => 'afterAction',
        ]);
    }

    public function beforeAction(ActionEvent $event)
    {
        if (!$this->notifyUserSettings->activeBrowser()) {
            return;
        }
        /** @var Post[] $posts */
        $posts = Post::find()->withoutTrack()->notOwner()->limit(10)->orderBy(['created_at' => SORT_DESC])->all();
        foreach ($posts as $post) {
            $alert = Json::encode([
                'id' => $post->id_post,
                'title' => $post->title,
            ]);
            Yii::$app->session->addFlash('alerts', $alert);
        }
    }

    public function afterAction(ActionEvent $event)
    {
        Yii::$app->session->removeFlash('alerts');
    }
}
