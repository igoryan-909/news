<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\base\Notify]].
 *
 * @see \app\models\base\Notify
 */
class NotifyQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([
            'fk_user' => \Yii::$app->user->id,
            'status' => 1,
        ]);
    }

    /**
     * @inheritdoc
     * @return \app\models\base\Notify[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\base\Notify|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
