<?php

namespace app\models\queries;
use yii\db\Query;
use Yii;

/**
 * This is the ActiveQuery class for [[\app\models\base\Post]].
 *
 * @see \app\models\base\Post
 */
class PostQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @return $this
     */
    public function withoutTrack()
    {
        return $this->andWhere(['not exists', (new Query())
            ->select('id_post_track')
            ->from('post_track')
            ->where([
                'fk_user' => Yii::$app->user->id,
            ])
            ->andWhere('fk_post = post.id_post')]);
    }

    /**
     * @return $this
     */
    public function notOwner()
    {
        return $this->andWhere(['<>', 'fk_user', Yii::$app->user->id]);
    }

    /**
     * @inheritdoc
     * @return \app\models\base\Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\base\Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
