<?php

use yii\helpers\Html;
use app\components\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= (Yii::$app->user->can('create'))
            ? Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'showModalButton btn btn-success'])
            : '';
        ?>
    </p>
<?php Pjax::begin(['id' => 'post-all']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{summary}{sizer}\n{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'class' => 'yii\grid\CheckboxColumn',
                'header' => Yii::t('app', 'Статус'),
                'checkboxOptions' => function ($model) {
                    return [
                        'value' => $model->id_post,
                        'data-action' => 'filter-checkbox',
                        'checked' => $model->status === 1,
                        'disabled' => !Yii::$app->user->can('update', ['post' => $model]),
                    ];
                },
            ],

            [
                'label' => Yii::t('app', 'Изображение'),
                'value' => function (\app\models\base\Post $model) {
                    /** @var \app\models\base\PostImage $image */
                    $image = $model->getPostImages()->one();
                    if (!is_null($image)) {
                        return Yii::getAlias('@web/uploads') . DIRECTORY_SEPARATOR . $image->thumb_path;
                    }
                    return $model->getPostImages()->one();
                },
                'format' => 'image',
            ],
            [
                'attribute' => 'fkUser.username',
                'value' => function ($model) {
                    return Yii::$app->user->can('admin')
                        ? Html::a($model->fkUser->username, ['user/admin/update', 'id' => $model->fk_user], [
                            'target' => '_blank',
                        ])
                        : $model->fkUser->username;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'title',
                'value' => function ($model) {
                    return Html::a($model->title, ['post/view', 'id' => $model->id_post]);
                },
                'format' => 'raw',
            ],
            'preview',
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

<?php
$js = <<<JS
$(document).on('change.yiiGridView', "#w0 input[data-action=filter-checkbox]", function (event) {
    $.ajax({
        type: "post",
        url : 'post/update/?id=' + $(this).attr('value'),
        data: {'Post[status]' : ($(this).is(':checked') ? 1 : 0)},
        success : function (result) {
            $.pjax.reload('#p0');
        }
    });
});
JS;

$this->registerJs($js);
?>
