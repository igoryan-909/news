<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= (Yii::$app->user->can('update', ['post' => $model])) ? Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_post], ['class' => 'showModalButton btn btn-primary']) : '' ?>
        <?= (Yii::$app->user->can('delete', ['post' => $model])) ? Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_post], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) : '' ?>
    </p>

    <?php \yii\widgets\Pjax::begin(['id' => 'post-view']); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_post',
            'fkUser.username',
            'preview',
            'content:ntext',
            'created_at:datetime',
            'updated_at:datetime',
            'title',
        ],
    ]) ?>

    <?php \yii\widgets\Pjax::end(); ?>

</div>
