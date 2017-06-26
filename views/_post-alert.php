<?php
if (is_array($alerts = Yii::$app->session->getFlash('alerts'))) {
    foreach ($alerts as $item) {
        $alert = \yii\helpers\Json::decode($item);
        $jsFunc = <<<JS
function () {
    $.ajax({
        url : '/post-track/create/?id={$alert['id']}',
        type : 'post'
    });
}
JS;

        echo \yii\bootstrap\Alert::widget([
            'options' => [
                'id' => 'alert-post-' . $alert['id'],
                'class' => 'alert-info',
                'value' => $alert['id'],
            ],
            'clientEvents' => ['closed.bs.alert' => $jsFunc],
            'body' => \yii\helpers\Html::a($alert['title'], ['/post/view', 'id' => $alert['id']]),
        ]);
    }
}
?>

