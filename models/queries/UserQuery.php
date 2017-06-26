<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\base\User]].
 *
 * @see \app\models\base\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\base\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\base\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
