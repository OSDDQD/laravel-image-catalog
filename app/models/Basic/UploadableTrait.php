<?php

namespace Basic;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait UploadableTrait
{

    public function getUploadedFilename($ext = null)
    {
        $filename = $this->getUploadSlug() . '-' . $this->id.substr(md5(time()), 0, 4);
        if ($ext)
            $filename .= '.' . $ext;
        return $filename;
    }

    public function uploadImage(UploadedFile $file, $imageField)
    {
        switch ($file->getMimeType()) {
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $ext = 'jpg';
                break;

            case 'image/png':
                $ext = 'png';
                break;

            case 'image/gif':
                $ext = 'gif';
                break;

            default:
                return 'Type not allowed';
                break;
        }

        $this->$imageField = $this->getUploadedFileName($ext);

        try {
            $file->move(self::getUploadPath(), $this->$imageField);
        }
        catch (\Exception $e) {
            if (!$this->errors)
                $this->errors = new MessageBag([$imageField => \Lang::get('validation.custom.image.upload_failed', ['message' => $e->getMessage()])]);
            return false;
        }

        $this->save();
        return true;
    }

    public function removeImage($imageField)
    {
        if (!$this->$imageField)
            return true;

        $fs = new Filesystem();
        $file = self::getUploadPath() . '/' . $this->$imageField;

        try {
            $fs->delete($file);
            $this->$imageField = '';
        }
        catch (\Exception $e) {
            if (!$this->errors)
                $this->errors = new MessageBag([$imageField => \Lang::get('validation.custom.image.removal_failed', ['message' => $e->getMessage()])]);
            return false;
        }

        $this->save();
        return true;
    }

}