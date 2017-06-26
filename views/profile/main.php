<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\Nav;

/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\User $user
 * @var string $content
 */

$this->title = $user->username;
?>
<h1><?= \yii\helpers\Html::encode($this->title) ?></h1>
<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                        [
                            'label' => Yii::t('user', 'Account details'),
                            'url' => ['/user/profile/update', 'id' => $user->id]
                        ],
                        [
                            'label' => Yii::t('user', 'Profile details'),
                            'url' => ['/user/profile/update-profile', 'id' => $user->id]
                        ],
                        ['label' => Yii::t('user', 'Information'), 'url' => ['/user/profile/info', 'id' => $user->id]],
                        [
                            'label' => Yii::t('app', 'Уведомления'),
                            'url' => ['/user/profile/notifies', 'id' => $user->id],
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
