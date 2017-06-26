<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PostTrack */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Post Track',
]) . $model->id_post_track;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Post Tracks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_post_track, 'url' => ['view', 'id' => $model->id_post_track]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="post-track-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
