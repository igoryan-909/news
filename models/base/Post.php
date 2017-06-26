<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id_post
 * @property integer $fk_user
 * @property string $preview
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $title
 * @property integer $status
 *
 * @property User $fkUser
 * @property PostImage[] $postImages
 * @property PostTrack[] $postTracks
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_user', 'created_at', 'updated_at', 'status'], 'integer'],
            [['content'], 'string'],
            [['preview'], 'string', 'max' => 500],
            [['title'], 'string', 'max' => 255],
            [['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_post' => Yii::t('app', 'Записи'),
            'fk_user' => Yii::t('app', 'Пользователь'),
            'preview' => Yii::t('app', 'Превью'),
            'content' => Yii::t('app', 'Содержимое'),
            'created_at' => Yii::t('app', 'Создан'),
            'updated_at' => Yii::t('app', 'Обновлен'),
            'title' => Yii::t('app', 'Заголовок'),
            'status' => Yii::t('app', 'Статус'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostImages()
    {
        return $this->hasMany(PostImage::className(), ['fk_post' => 'id_post']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTracks()
    {
        return $this->hasMany(PostTrack::className(), ['fk_post' => 'id_post']);
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\PostQuery(get_called_class());
    }
}
