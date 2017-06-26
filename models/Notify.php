<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 21.06.2017
 * Time: 14:38
 */

namespace app\models;


class Notify extends \app\models\base\Notify
{
    const SCENARIO_STATUS = 'status';


    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_STATUS => ['status'],
        ]);
    }
}
