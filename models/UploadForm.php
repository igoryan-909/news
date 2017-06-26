<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 20.06.2017
 * Time: 15:51
 */

namespace app\models;


use app\components\helpers\FileHelper;
use yii\base\Model;
use yii\imagine\Image;
use yii\web\UploadedFile;
use Yii;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;
    /**
     * @var string
     */
    public $pathAlias = '@webroot/uploads';
    /**
     * @var int
     */
    public $thumbWidth = 120;
    /**
     * @var int
     */
    public $thumbHeight = 120;
    /**
     * @var array
     */
    private $_fileNames = [];


    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $path = (empty(Yii::$app->params['uploadDir']))
                ? Yii::getAlias($this->pathAlias) . DIRECTORY_SEPARATOR
                : Yii::getAlias('@webroot' . Yii::$app->params['uploadDir']) . DIRECTORY_SEPARATOR;
            if (!is_dir($path)) {
                FileHelper::createDirectory($path);
            }
            foreach ($this->imageFiles as $file) {
                $fileName = FileHelper::getRandomFileName($path . DIRECTORY_SEPARATOR, $file->extension);
                $fullName = $fileName . '.' . $file->extension;
                $fullPath = $path . $fullName;
                $thumbName = $fileName
                    . '-' . $this->thumbWidth . 'x' . $this->thumbHeight
                    . '.' . $file->extension;
                $file->saveAs($fullPath);
                Image::thumbnail($fullPath, $this->thumbWidth, $this->thumbHeight)
                    ->save($path . $thumbName, ['quality' => 75]);
                $this->_fileNames[] = [
                    'full' => $fullName,
                    'thumb' => $thumbName,
                ];
            }
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getFileNames()
    {
        return $this->_fileNames;
    }
}
