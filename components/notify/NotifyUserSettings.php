<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 22.06.2017
 * Time: 17:33
 */

namespace app\components\notify;


use app\components\helpers\NotifyHelper;
use app\models\Notify;
use yii\base\Object;

class NotifyUserSettings extends Object
{
    /**
     * @var \app\models\base\Notify|array|bool|null
     */
    private $_browser;
    /**
     * @var bool
     */
    private $_activeBrowser;


    /**
     * @return \app\models\base\Notify|array|bool|null
     */
    public function getBrowser()
    {
        if (is_null($this->_browser)) {
            if (($this->_browser = Notify::find()
                    ->where(['client' => NotifyHelper::CLIENT_BROWSER])
                    ->active()
                    ->one()) === null) {
            }
        }

        return $this->_browser;
    }

    /**
     * @return bool
     */
    public function activeBrowser()
    {
        if (is_null($this->_activeBrowser)) {
            $this->_activeBrowser = $this->getBrowser() !== null;
        }

        return  $this->_activeBrowser;
    }
}
