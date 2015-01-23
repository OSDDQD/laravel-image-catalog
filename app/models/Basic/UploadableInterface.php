<?php

namespace Basic;

interface UploadableInterface
{

    /**
     * Returns directory name where uploaded files are stored.
     * Starting slash should be included.
     *
     * @return string
     */
    public static function getUploadDir();

    /**
     * Returns path to directory where uploaded files are stored.
     * Usually it returns Config::get('app.uploads_root').self::getUploadDir()
     *
     * @return string
     */
    public static function getUploadPath();

    /**
     * Returns slug used to name uploaded files like 'slug-id.ext'
     *
     * @return string
     */
    public static function getUploadSlug();

}