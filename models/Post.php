<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 19.06.2017
 * Time: 23:34
 */

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

class Post extends \app\models\base\Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_user', 'created_at', 'updated_at', 'status'], 'integer'],
            [['content', 'preview', 'title'], 'required'],
            [['content'], 'string'],
            [['preview'], 'string', 'max' => 500],
            [['title'], 'string', 'max' => 255],
            [['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user' => 'id']],
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::className(),
        ]);
    }

    public function transactions()
    {
        return array_merge(parent::transactions(), [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->fk_user = Yii::$app->user->id;
            }

            return true;
        }

        return false;
    }
}
