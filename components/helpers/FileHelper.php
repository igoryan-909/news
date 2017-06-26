<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 20.06.2017
 * Time: 19:15
 */

namespace app\components\helpers;


class FileHelper extends \yii\helpers\FileHelper
{
    public static function getRandomFileName($path, $extension = '')
    {
        $extension = !empty($extension) ? '.' . $extension : '';

        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));

        return $name;
    }
}
