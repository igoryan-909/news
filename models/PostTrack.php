<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 21.06.2017
 * Time: 19:38
 */

namespace app\models;


use Yii;
use yii\helpers\Json;

class PostTrack extends \app\models\base\PostTrack
{
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            if (is_array($alerts = Yii::$app->session->get('alerts'))) {
                $alerts = array_filter($alerts, function ($alert) {
                    $alert = Json::decode($alert);
                    return $alert['id'] !== $this->fk_post;
                });
                Yii::$app->session->setFlash('alerts', $alerts);
            }
        }
    }
}
