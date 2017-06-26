<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Notify */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Notify',
]) . $model->id_notify;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_notify, 'url' => ['view', 'id' => $model->id_notify]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="notify-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
