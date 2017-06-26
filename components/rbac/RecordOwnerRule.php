<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 19.06.2017
 * Time: 21:49
 */

namespace app\components\rbac;


use yii\rbac\Rule;

class RecordOwnerRule extends Rule
{
    /**
     * @var string
     */
    public $name = 'ownerOnly';


    /**
     * @param int|string $user
     * @param \yii\rbac\Item $item
     * @param array $params
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        $userAttribute = $params['userAttribute'] ?? 'fk_user';
        return isset($params['post']->{$userAttribute}) ? $user == $params['post']->{$userAttribute} : false;
    }
}
