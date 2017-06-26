<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 21.06.2017
 * Time: 16:49
 */

namespace app\components\helpers;


use app\models\base\Notify;
use Yii;

class NotifyHelper
{
    const CLIENT_EMAIL = 1;
    const CLIENT_BROWSER = 2;


    /**
     * @param Notify $model
     * @return string
     */
    public static function label(Notify $model)
    {
        switch ($model->client) {
            case self::CLIENT_EMAIL :
                return Yii::t('app', 'Включить уведомления на e-mail');
                break;
            case self::CLIENT_BROWSER :
                return Yii::t('app', 'Включить уведомления в браузере');
        }

        return '';
    }
}
