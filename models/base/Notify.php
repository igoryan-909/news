<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "notify".
 *
 * @property integer $id_notify
 * @property integer $fk_user
 * @property integer $client
 * @property resource $client_data
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property User $fkUser
 */
class Notify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_user'], 'required'],
            [['fk_user', 'client', 'created_at', 'updated_at', 'status'], 'integer'],
            [['client_data'], 'string'],
            [['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_notify' => Yii::t('app', 'Идентификатор'),
            'fk_user' => Yii::t('app', 'Пользователь'),
            'client' => Yii::t('app', 'Тип уведомления'),
            'client_data' => Yii::t('app', 'Данные клиента'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
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
     * @inheritdoc
     * @return \app\models\queries\NotifyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\NotifyQuery(get_called_class());
    }
}
