<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 * @var \app\models\base\Notify[] $notifies
 */
?>

<?php $this->beginContent('@app/views/profile/main.php', ['user' => $user]) ?>

<?php foreach ($notifies as $notify) {
    echo $this->render('_notify', ['notify' => $notify]);
} ?>

<?php $this->endContent() ?>

<?php
$js = <<<JS
$('[id^="notify-status-"]').on('change', function() {
    var form = $(this).parents('form');
    var formData = new FormData(form[0]);
    $.ajax({
        url : '/notify/update-status?id=' + form.attr('id'),
        type : 'POST',
        data : formData,
        cache : false,
        contentType : false,
        processData : false
    });
});
JS;
$this->registerJs($js);
?>
