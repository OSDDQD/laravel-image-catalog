<?php

namespace Slider;

use Basic\UploadableInterface;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Image implements UploadableInterface
{
    public $id;

    /**
     * Returns directory name where uploaded files are stored.
     * Starting slash should be included.
     *
     * @return string
     */
    public static function getUploadDir()
    {
        return '/sliders';
    }

    /**
     * Returns path to directory where uploaded files are stored.
     * Usually it returns Config::get('app.uploads_root').self::getUploadDir()
     *
     * @return string
     */
    public static function getUploadPath()
    {
        return \Config::get('app.uploads_root').self::getUploadDir();
    }

    /**
     * Returns slug used to name uploaded files like 'slug-id.ext'
     *
     * @return string
     */
    public static function getUploadSlug()
    {
        return 'top-slider';
    }

    public function getUploadedFilename($ext = null)
    {
        $filename = $this->getUploadSlug() . '-' . (int) $this->id;
        if ($ext)
            $filename .= '.' . $ext;
        return $filename;
    }

    public function uploadImage(UploadedFile $file)
    {
        switch ($file->getMimeType()) {
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $srcIm = imagecreatefromjpeg($file);
                break;

            case 'image/png':
                $srcIm = imagecreatefrompng($file);
                break;

            case 'image/gif':
                $srcIm = imagecreatefromgif($file);
                break;

            default:
                return false;
                break;
        }

        try {
            imagejpeg($srcIm, $this->getUploadPath() . '/' . $this->getUploadedFileName('jpg'), 95);
            imagedestroy($srcIm);
            unlink($file);
        }
        catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function removeImage()
    {
        $fs = new Filesystem();
        $file = self::getUploadPath() . '/' . $this->getUploadedFileName('jpg');

        try {
            $fs->delete($file);
        }
        catch (\Exception $e) {
            return false;
        }

        return true;
    }

}