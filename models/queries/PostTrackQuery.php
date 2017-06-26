<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\base\PostTrack]].
 *
 * @see \app\models\base\PostTrack
 */
class PostTrackQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\base\PostTrack[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\base\PostTrack|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
