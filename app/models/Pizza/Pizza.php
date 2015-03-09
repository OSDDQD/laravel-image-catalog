<?php

namespace Pizza;

use \Basic\TranslatableTrait;
use \Basic\UploadableInterface;
use \Basic\UploadableTrait;

class Pizza extends \BaseModel implements UploadableInterface
{
    use TranslatableTrait,
        UploadableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pizzas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['position', 'title', 'description', 'is_visible', 'max_weight', 'size', 'is_prepared', 'is_novelty', 'is_popular', 'price', 'image'];

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

        static::created(function(Pizza $entity) {
            $entity->alterSiblingsPosition('increment');
        });
        static::updating(function(Pizza $entity) {
            if ($entity->isDirty('position')) {
                $entity->alterSiblingsPosition('decrement', true);
                $entity->alterSiblingsPosition('increment');
            }
        });
        static::deleted(function(Pizza $entity) {
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
        return '/pizzas/pizza';
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
        return 'pizza';
    }

    public function options()
    {
        return $this->hasMany('\Pizza\Option');
    }

    public function setPositionAttribute($value)
    {
        $maxPosition = Pizza::count();

        if (!$this->id)
            $maxPosition++;

        if ($value > $maxPosition)
            $value = $maxPosition;

        if ($value < 1)
            $value = 1;

        $this->attributes['position'] = $value;
    }

    public function setMaxWeightAttribute($value)
    {
        $this->attributes['max_weight'] = floatval(preg_replace('/[^\d.]/', '', $value));
    }

    public function setSizeAttribute($value)
    {
        $this->attributes['size'] = floatval(preg_replace('/[^\d.]/', '', $value));
    }

    private function alterSiblingsPosition($method, $useOriginal = false, $condition = '>=') {
        $position = $useOriginal ? $this->original['position'] : $this->position;

        $query = Pizza::where('position', $condition, $position)->where('id', '!=', $this->id);
        $result = $query->get();
        foreach($result as $row)
            $row->$method('position');
    }

}