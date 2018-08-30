<?php

namespace app\core\behaviors\file;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class ActionFile
 * @package app\core\behaviors\file
 */
class ActionFile extends Behavior
{
    /**
     * @var string
     */
    public $attribute;
    /**
     * @var string
     */
    public $deleteAttribute;
    /**
     * @var string
     */
    public $path;
    /**
     * @var string
     */
    public $pathUrl;
    /**
     * @var string
     */
    public $name = null;
    /**
     * @var UploadedFile
     */
    protected $uploadedFileInstance = null;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function beforeValidate()
    {
        // Если из вне присваеваем аттрибуту экземпляр класса UploadedFile
        if ($this->getOwnerAttribute() instanceof UploadedFile) {
            $this->uploadedFileInstance = $this->getOwnerAttribute();
        }

        if ($instance = $this->getUploadedFileInstance()) {
            $this->setOwnerAttribute($instance);
        }
    }

    public function beforeSave()
    {
        if ($this->isDelete()) {
            $this->deleteCurrentFile();
            $this->setOwnerAttribute(null);
        }

        if ($this->uploadFile($this->getTempPath()) && $this->saveFile($this->getPath())) {
            $this->deleteTempFile();

            if (!$this->owner->isNewRecord) {
                $this->deleteOldFile();
            }
        } elseif (!$this->owner->isNewRecord) {
            $this->setOwnerAttribute($this->getOldAttribute());

            if ($this->isDelete()) {
                $this->setOwnerAttribute(null);
            }
        }
    }

    public function beforeDelete()
    {
        return $this->deleteCurrentFile();
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function saveFile($path): bool
    {
        $path = $path . DIRECTORY_SEPARATOR . $this->getNameDir($this->getOwnerAttribute());

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        return copy($this->getTempFilePath(), $path . DIRECTORY_SEPARATOR . $this->getOwnerAttribute());
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function uploadFile($path): bool
    {
        $instance = $this->getUploadedFileInstance();
        if ($instance instanceof UploadedFile) {

            $nameExtension = $this->getName() . '.' . $instance->getExtension();
            $file = $path . DIRECTORY_SEPARATOR . $nameExtension;

            $this->setOwnerAttribute($nameExtension);

            return $instance->saveAs($file);
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function isDelete(): bool
    {
        return $this->owner->{$this->deleteAttribute} ?? false;
    }

    /**
     * @return bool
     */
    protected function deleteCurrentFile(): bool
    {
        return $this->deleteFile($this->getFilePath());
    }

    /**
     * @return bool
     */
    protected function deleteTempFile(): bool
    {
        return $this->deleteFile($this->getTempFilePath());
    }

    /**
     * @return bool
     */
    protected function deleteOldFile(): bool
    {
        $attribute = $this->getOldAttribute();
        return $this->deleteFile($this->getPath() . DIRECTORY_SEPARATOR . $this->getNameDir($attribute) . DIRECTORY_SEPARATOR . $attribute);
    }

    /**
     * @param string $file
     * @return bool
     */
    protected function deleteFile($file): bool
    {
        if (is_file($file)) {
            return unlink($file);
        }
        return false;
    }

    /**
     * @return string
     */
    protected function getTempPath(): string
    {
        return Yii::$app->tempPath;
    }

    /**
     * @return string
     */
    protected function getTempFilePath(): string
    {
        return $this->getTempPath() . DIRECTORY_SEPARATOR . $this->getOwnerAttribute();
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return Yii::getAlias($this->path);
    }

    /**
     * @return string
     */
    public function getPathUrl(): string
    {
        return Yii::getAlias($this->pathUrl);
    }

    /**
     * @return string
     */
    public function getFileUrl(): string
    {
        $attribute = $this->getOldAttribute() != '' ? $this->getOldAttribute() : $this->getOwnerAttribute();

        return $this->getPathUrl() . '/' . $this->getNameDir($attribute) . '/' . $attribute;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        $attribute = $this->getOldAttribute() != '' ? $this->getOldAttribute() : $this->getOwnerAttribute();

        return $this->getPath() . DIRECTORY_SEPARATOR . $this->getNameDir($attribute) . DIRECTORY_SEPARATOR . $attribute;
    }

    protected function getOldAttribute()
    {
        return (isset($this->owner->oldAttributes[$this->attribute])) ? $this->owner->oldAttributes[$this->attribute] : '';
    }

    protected function getOwnerAttribute()
    {
        return $this->owner->{$this->attribute};
    }

    protected function setOwnerAttribute($value)
    {
        $this->owner->{$this->attribute} = $value;
    }

    /**
     * @return string
     */
    protected function getName(): string
    {
        if (is_null($this->name)) {
            $instance = $this->owner->{$this->attribute};
            $this->name = md5(uniqid($instance));
        }
        return $this->name;
    }

    /**
     * @return null|UploadedFile
     */
    protected function getUploadedFileInstance()
    {
        if (is_null($this->uploadedFileInstance)) {
            $this->uploadedFileInstance = UploadedFile::getInstance($this->owner, $this->attribute);
        }

        return $this->uploadedFileInstance;
    }

    /**
     * @param string $string
     * @param int $length
     * @return string
     */
    protected function getNameDir($string = '', $length = 1): string
    {
        return substr($string, 0, $length);
    }

    /**
     * @return bool
     */
    public function fileExist(): bool
    {
        return is_file($this->getFilePath());
    }
}