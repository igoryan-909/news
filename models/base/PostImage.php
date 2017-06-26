<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "post_image".
 *
 * @property integer $id_post_image
 * @property integer $fk_post
 * @property string $path
 * @property string $thumb_path
 * @property integer $created_at
 *
 * @property Post $fkPost
 */
class PostImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_post', 'created_at'], 'integer'],
            [['path', 'thumb_path'], 'string', 'max' => 500],
            [['fk_post'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['fk_post' => 'id_post']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_post_image' => Yii::t('app', 'Id Post Image'),
            'fk_post' => Yii::t('app', 'Запись'),
            'path' => Yii::t('app', 'Путь'),
            'thumb_path' => Yii::t('app', 'Путь миниатюры'),
            'created_at' => Yii::t('app', 'Создан'),
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
     * @inheritdoc
     * @return \app\models\queries\PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\PostQuery(get_called_class());
    }
}
