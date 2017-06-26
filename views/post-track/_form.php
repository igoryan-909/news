<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostTrack */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-track-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_post')->textInput() ?>

    <?= $form->field($model, 'fk_user')->textInput() ?>

    <?= $form->field($model, 'read_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
