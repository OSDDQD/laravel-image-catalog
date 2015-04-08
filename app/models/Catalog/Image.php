<?php

namespace Catalog;

use Basic\PositionedTrait;
use \Basic\TranslatableTrait;
use \Basic\UploadableInterface;
use \Basic\UploadableTrait;
use Illuminate\Filesystem\Filesystem;

class Image extends \Eloquent implements UploadableInterface {

    use TranslatableTrait,
        UploadableTrait,
        PositionedTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catalog_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['position', 'album_id', 'title', 'description', 'is_visible', 'image', 'created_at', 'updated_at'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'description'];

    protected static $rules = [];

    /**
     * Adds observer inheritance
     */
    public static function boot()
    {
        parent::boot();

        static::created(function(Image $entity) {
            $entity->alterSiblingsPosition('increment');
        });

        static::updating(function(Image $entity) {
            if ($entity->isDirty('album_id') or $entity->isDirty('position')) {
                $entity->alterSiblingsPosition('decrement', true);
                $entity->alterSiblingsPosition('increment');
            }
        });

        static::deleted(function(Image $entity) {
            $entity->alterSiblingsPosition('decrement');
            $entity->removeImage('image');
        });
    }

    /**
     * Returns directory name where uploaded files are stored.
     * Starting slash should be included.
     *
     * @return string
     */
    public static function getUploadDir()
    {
        return '/catalog/image';
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
        return 'image';
    }

    public function album()
    {
        return $this->belongsTo('\Catalog\Album');
    }


    public function setPositionAttribute($value)
    {
        if (!$this->id) {
            $this->attributes['position'] = $value;
        } else {
            $maxPosition = Image::whereAlbumId($this->album_id)->count();

            if ($this->album_id != $this->getOriginal('album_id'))
                $maxPosition++;

            if ($value > $maxPosition)
                $value = $maxPosition;

            if ($value < 1)
                $value = 1;

            $this->attributes['position'] = $value;
        }
    }

    private function alterSiblingsPosition($method, $useOriginal = false, $condition = '>=') {
        $albumId = $useOriginal ? $this->original['album_id'] : $this->album_id;
        $position = $useOriginal ? $this->original['position'] : $this->position;

        $query = Image::whereAlbumId($albumId);
        $query->where('position', $condition, $position)->where('id', '!=', $this->id);
        $result = $query->get();
        foreach($result as $row)
            $row->$method('position');
    }

}