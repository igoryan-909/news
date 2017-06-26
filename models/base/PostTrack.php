<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "post_track".
 *
 * @property integer $id_post_track
 * @property integer $fk_post
 * @property integer $fk_user
 * @property integer $read_at
 *
 * @property Post $fkPost
 * @property User $fkUser
 */
class PostTrack extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_track';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_post', 'fk_user', 'read_at'], 'integer'],
            [['fk_post'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['fk_post' => 'id_post']],
            [['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_post_track' => Yii::t('app', 'Идентификатор'),
            'fk_post' => Yii::t('app', 'Запись'),
            'fk_user' => Yii::t('app', 'Пользователь'),
            'read_at' => Yii::t('app', 'Прочитано'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPost()
    {
        return $this->hasOne(Post::className(), ['id_post' => 'fk_post']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_user']);
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\PostTrackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\PostTrackQuery(get_called_class());
    }
}
