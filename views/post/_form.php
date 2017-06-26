<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $imageModel app\models\UploadForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => $model->formName(),
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preview')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?php if (($postImage = $model->getPostImages()->one()) !== null) {
        echo Html::img(Yii::getAlias('@web' . Yii::$app->params['uploadDir']) . DIRECTORY_SEPARATOR . $postImage->thumb_path);
    } ?>

    <?= $form->field($imageModel, 'imageFiles[]')->fileInput(['multiple' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
        $js = "
            $('form#" . $model->formName() . "').on('beforeSubmit', function(e) {
                var \$form = $(this);
                submitForm(\$form);
            }).on('submit', function(e) {
                e.preventDefault();
            });";
        $this->registerJs($js);
    ?>

</div>
