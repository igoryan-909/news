<?php
/**
 * @var \app\models\base\Notify $notify
 */
?>

<?php $form = \yii\widgets\ActiveForm::begin([
    'id' => $notify->id_notify,
]); ?>

<?= $form->field($notify, 'status')->widget(\kartik\checkbox\CheckboxX::classname(), [
    'options' => ['id' => 'notify-status-' . $notify->id_notify],
    'pluginOptions' => ['threeState' => false],
])->label(\app\components\helpers\NotifyHelper::label($notify)); ?>

<?php \yii\widgets\ActiveForm::end(); ?>
