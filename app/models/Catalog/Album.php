<?php
namespace Catalog;

use Basic\PositionedTrait;
use \Basic\TranslatableTrait;
use \Basic\UploadableInterface;
use \Basic\UploadableTrait;

class Album extends \Eloquent  implements UploadableInterface {

    use TranslatableTrait,
        UploadableTrait,
        PositionedTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catalog_albums';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['position', 'category_id', 'title', 'description', 'is_visible', 'image'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'description'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected static $rules = [];

    /**
     * Adds observer inheritance
     */
    public static function boot()
    {
        parent::boot();

        static::created(function(Album $entity) {
            $entity->alterSiblingsPosition('increment');
        });

        static::updating(function(Album $entity) {
            if ($entity->isDirty('category_id') or $entity->isDirty('position')) {
                $entity->alterSiblingsPosition('decrement', true);
                $entity->alterSiblingsPosition('increment');
            }
        });

        static::deleted(function(Album $entity) {
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
        return '/catalog/album';
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
        return 'album';
    }

    public function category()
    {
        return $this->belongsTo('\Catalog\Category');
    }

    public function images()
    {
        return $this->hasMany('\Catalog\Image');
    }

    public function setPositionAttribute($value)
    {
        if (!$this->id) {
            $this->attributes['position'] = $value;
        } else {
            $maxPosition = Album::whereCategoryId($this->category_id)->count();

            if ($this->category_id != $this->getOriginal('category_id'))
                $maxPosition++;

            if ($value > $maxPosition)
                $value = $maxPosition;

            if ($value < 1)
                $value = 1;

            $this->attributes['position'] = $value;
        }
    }

    private function alterSiblingsPosition($method, $useOriginal = false, $condition = '>=') {
        $categoryId = $useOriginal ? $this->original['category_id'] : $this->category_id;
        $position = $useOriginal ? $this->original['position'] : $this->position;

        $query = Album::whereCategoryId($categoryId);
        $query->where('position', $condition, $position)->where('id', '!=', $this->id);
        $result = $query->get();
        foreach($result as $row)
            $row->$method('position');
    }

}