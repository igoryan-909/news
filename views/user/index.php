<?php

use yii\helpers\Html;
use app\components\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= (Yii::$app->user->can('create'))
            ? Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'showModalButton btn btn-success'])
            : '';
        ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{summary}\n{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'username',
                'value' => function ($model) {
                    return Yii::$app->user->can('admin')
                        ? Html::a($model->username, ['admin/view', 'id' => $model->id], [
                            'target' => '_blank',
                        ])
                        : $model->fkUser->username;
                },
                'format' => 'raw',
            ],
            'email',
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => \kartik\daterange\DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'createTimeRange',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'Y-m-d',
                        ]
                    ]
                ]),
            ],
            [
                'attribute' => 'last_login_at',
                'format' => 'datetime',
                'filter' => \kartik\daterange\DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'loginTimeRange',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'Y-m-d',
                        ]
                    ]
                ]),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => function ($model) {
                        return Yii::$app->user->can('update', ['post' => $model]);
                    },
                    'delete' => function ($model) {
                        return Yii::$app->user->can('delete', ['post' => $model]);
                    },
                ],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'showModalButton',
                        ];
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]);
                        return Html::a($icon, $url, $options);
                    },
                    'delete',
                ],
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
