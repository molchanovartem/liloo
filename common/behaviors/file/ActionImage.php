<?php

namespace app\core\behaviors\file;

use yii\base\Exception;
use Imagine\Gd\Image;
use Imagine\Image\Point;
use Imagine\Image\Box;

/**
 * @todo
 * Class ActionImage
 * Класс не закончен, функции не используются
 * @package kigl\cef\core\behaviors\file
 * @author Kirill Golodaev <kirillgolodaev@gmail.com>
 */
class ActionImage extends ActionFile
{
    /**
     * @var array
     */
    public $crop = [];
    /**
     * @var Image
     */
    private $image;

    public function init()
    {
        parent::init();

        if (empty($this->crop['enable'])) {
            $this->crop['enable'] = false;
        }
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function saveFile($path): bool
    {
        $path = $path . DIRECTORY_SEPARATOR . $this->getNameDir($this->getOwnerAttribute());

        $imagine = new \Imagine\Gd\Imagine();

        $this->setImage($imagine->open($this->getTempFilePath()));

        if ($this->crop['enable']) {
            $this->cropImage();
        }

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $this->image->save($path . DIRECTORY_SEPARATOR . $this->getOwnerAttribute());

        return true;
    }

    protected function cropImage()
    {
        foreach (['x', 'y', 'width', 'height'] as $param) {
            if (empty($this->crop['x'])) {
                throw new Exception('Empty crop property '. $param);
            }
        }

        $x = $this->owner->{$this->crop['x']};
        $y = $this->owner->{$this->crop['y']};
        $width = $this->owner->{$this->crop['width']};
        $height = $this->owner->{$this->crop['height']};

        $image = $this->getImage();
        $image->crop(new Point($x, $y), new Box($width, $height));
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getImage()
    {
        if (!$this->image instanceof Image) {
            throw new Exception('No instance Image');
        }
        return $this->image;
    }

    /**
     * @param Image $image
     */
    protected function setImage(Image $image)
    {
        $this->image = $image;
    }

    /*
	protected function resize($width, $height)
	{
		$this->_image->resize(new Box($width, $height));
		
		return $this->_image;
	}

	public function resizeWidth($width)
	{
	  $ratio = $width / $this->_image->getSize()->getWidth();
	  $height = $this->_image->getSize()->getHeight() * $ratio;
	  $this->resize($width,$height);

	  return $this->_image;
	}

	public function resizeHeight($height)
	{
	  $ratio = $height / $this->_image->getSize()->getHeight();
    $width = $this->_size->getSize()->getWidth() * $ratio;
    $this->resize($width,$height);

    return $this->_image;
	}
    */
}
