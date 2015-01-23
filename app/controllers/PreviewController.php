<?php

class PreviewController extends BaseController {

    /**
     * Генерирует эскиз изображения выбранного файла
     *
     * @param $path
     * @return Response
     */
    public function uploaded($object, $id, $mode, $format)
    {
//        $object::getUploadPath();
//        $this->uploadsPath = $this->get('kernel')->getRootDir() . "/uploads";
//
//        $pathParts = pathinfo($path);
//        $ext  = strtolower($pathParts['extension']);

//        $fileRootPath = $this->uploadsPath . "/files/" . $pathParts['basename'];

        $fileRootPath = app_path() . "/uploads/photos/$object-$id.$format";

        if (!file_exists($fileRootPath)) {
            $srcIm = imagecreatefromjpeg(realpath(__DIR__ . "/../Resources/public/images/defaultimage.jpg"));
        } else {
            switch ($format) {
                case "jpg":
                case "jpeg":
                    $srcIm = imagecreatefromjpeg(realpath($fileRootPath));
                    break;

                case "png":
                    $srcIm = imagecreatefrompng(realpath($fileRootPath));
                    break;

                case "gif":
                    $srcIm = imagecreatefromgif(realpath($fileRootPath));
                    break;

                default:
                    $srcIm = imagecreatefromjpeg(realpath(__DIR__ . "/../Resources/public/images/defaultimage.jpg"));
                    break;
            }
        }

        $transformations = Config::get('app.preview_transform');

        $dstW = $transformations[$object][$mode][0];
        $dstH = $transformations[$object][$mode][1];

        return $this->makeResponse($srcIm, $dstW, $dstH);
    }


    /**
     * Генерирует эскиз изображения выбранного файла
     *
     * @param $path
     * @return Response
     */
    public function managed($object, $mode, $format, $file)
    {
        $object = strtolower($object);
        $mode = strtolower($mode);
        $format = strtolower($format);
        $file = strtolower($file);

        $transformations = Config::get('app.preview_transform');

        if (!array_key_exists($object, $transformations))
            return "$object type not supported";
        if ($mode != 'full' and !array_key_exists($mode, $transformations[$object]))
            return "$mode transformation mode not supported for $object";

        $fileRootPath = $transformations[$object]['_class']::getUploadPath() . '/' . $file;

        if (!file_exists($fileRootPath)) {
            $srcIm = imagecreatefromjpeg(realpath(__DIR__ . "/../Resources/public/images/defaultimage.jpg"));
        } else {
            switch (pathinfo($fileRootPath, PATHINFO_EXTENSION)) {
                case "jpg":
                    $srcIm = imagecreatefromjpeg(realpath($fileRootPath));
                    break;

                case "png":
                    $srcIm = imagecreatefrompng(realpath($fileRootPath));
                    break;

                case "gif":
                    $srcIm = imagecreatefromgif(realpath($fileRootPath));
                    break;

                default:
                    $srcIm = imagecreatefromjpeg(realpath(__DIR__ . "/../Resources/public/images/defaultimage.jpg"));
                    break;
            }
        }

        if ($mode == 'full') {
            $dstW = imagesx($srcIm);
            $dstH = imagesy($srcIm);
        } else {
            $dstW = $transformations[$object][$mode][0];
            $dstH = $transformations[$object][$mode][1];
        }

        return $this->makeResponse($srcIm, $dstW, $dstH);
    }

    /**
     * Создание эскиза, сохранение кэш файла и отдача Response
     *
     * @param $srcIm
     * @param $dstW
     * @param $dstH
     * @param string $format
     * @param null $cacheFile
     * @return Response
     */
    private function makeResponse($srcIm, $dstW, $dstH, $format = 'jpg', $cacheFile = null) {
        if ($cacheFile) {
            $f = new \SplFileInfo(pathinfo($cacheFile, PATHINFO_DIRNAME));

            if (!$f->isDir()) {
                try {
                    $fs = new Filesystem();
                    $fs->mkdir($f);
                }
                catch (IOException $e) {
                    exit('Ошибка при создании директории для хранения эскизов: ' . $e->getMessage());
                }
            } else {
                if (!$f->isReadable())
                    exit('Кэш директория эскизов недоступна для чтения');
                if (!$f->isWritable())
                    exit('Кэш директория эскизов недоступна для записи');
            }
        }

        $dstIm = $this->fillImage($srcIm, abs((int) $dstW), abs((int) $dstH));
        imagedestroy($srcIm);

        ob_start();
        switch (strtolower($format)) {
            default:
            case 'jpg':
            case 'jpeg':
                imagejpeg($dstIm, $cacheFile, 92);
                $fileMimeType = 'image/jpeg';
                $fileRef = 'jpg';
                break;

            case 'png':
                imagepng($dstIm, $cacheFile);
                $fileMimeType = 'image/png';
                $fileRef = 'png';
                break;

            case 'gif':
                imagegif($dstIm, $cacheFile);
                $fileMimeType = 'image/gif';
                $fileRef = 'gif';
                break;
        }
        if ($cacheFile)
            readfile($cacheFile);
        $img = ob_get_clean();
        imagedestroy($dstIm);

        return Response::make($img)
            ->header('Content-Type', $fileMimeType)
            ->header('Content-Disposition', 'inline; filename="image.' . $fileRef . '"');
    }

    /**
     * Трансформирует передаваемое изображение так, чтобы оно занимало заданную область
     * и возвращает результат в виде ресурса изображения
     *
     * @param resource $srcIm Ресурс изображения
     * @param integer $resWidth Ширина заполняемой области
     * @param integer $resHeight Высота заполняемой области
     * @return resource
     */
    private function fillImage($srcIm, $resWidth, $resHeight)
    {
        $srcWidth  = imagesx($srcIm);
        $srcHeight = imagesy($srcIm);

        $scaledWidth  = $resHeight * $srcWidth / $srcHeight;

        if ($scaledWidth > $resWidth) {
            $tWidth  = floor($srcHeight * $resWidth / $resHeight);
            $tHeight = $srcHeight;
            $srcX = ($srcWidth - $tWidth) / 2;
            $srcY = 0;
        }
        else {
            $tWidth  = $srcWidth;
            $tHeight = floor($srcWidth * $resHeight / $resWidth);
            $srcX = 0;
            $srcY = ($srcHeight - $tHeight) / 2;
        }

        $resIm = imagecreatetruecolor($resWidth, $resHeight);
        imagefill($resIm, 0, 0, imagecolorallocate($resIm, 255, 255, 255));
        imagecopyresampled($resIm, $srcIm, 0, 0, $srcX, $srcY, $resWidth, $resHeight, $tWidth, $tHeight);

        return $resIm;
    }

    /**
     * Трансформирует передаваемое изображение так, чтобы оно умещалось по центру в
     * заданную область и возвращает результат в виде ресурса изображения
     *
     * @param resource $srcIm Ресурс изображения
     * @param integer $resWidth Ширина заполняемой области
     * @param integer $resHeight Высота заполняемой области
     * @return resource
     */
    private function fitImage($srcIm, $resWidth, $resHeight)
    {
        $srcWidth = imagesx($srcIm);
        $srcHeight = imagesy($srcIm);

        $tWidth  = $resWidth;
        $tHeight = $resHeight;

        if ($srcWidth >= $resWidth or $srcHeight >= $resHeight) {
            if ($srcWidth > $srcHeight) {
                $tHeight = $srcHeight * $resWidth / $srcWidth;
            }
            if ($srcHeight > $srcWidth) {
                $tWidth = $srcWidth * $resHeight / $srcHeight;
            }
        }
        else {
            if ($srcWidth < $resWidth) {
                $resX = ($resWidth - $srcWidth) / 2;
                $tHeight = $srcHeight;
            }
            if ($tHeight != $srcHeight and $srcHeight < $resHeight) {
                $resY = ($resHeight - $srcHeight) / 2;
                $tWidth = $srcWidth;
            }
        }
        $resIm = imagecreatetruecolor($tWidth, $tHeight);
        imagefill($resIm, 0, 0, imagecolorallocate($resIm, 255, 255, 255));

        if ($srcWidth >= $resWidth or $srcHeight >= $resHeight) {
            imagecopyresampled($resIm, $srcIm, 0, 0, 0, 0, $tWidth, $tHeight, $srcWidth, $srcHeight);
        }
        else {
            imagecopyresampled($resIm, $srcIm, $resX, $resY, 0, 0, $srcWidth, $srcHeight, $srcWidth, $srcHeight);
        }

        return $resIm;
    }

}
