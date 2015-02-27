<?php

namespace Menu;

use \Basic\TranslatableTrait;

class Category extends \BaseModel
{
    use TranslatableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['position', 'title', 'is_visible'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['title'];

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

        static::created(function(Category $entity) {
            $entity->alterSiblingsPosition('increment');
        });
        static::updating(function(Category $entity) {
            if ($entity->isDirty('position')) {
                $entity->alterSiblingsPosition('decrement', true);
                $entity->alterSiblingsPosition('increment');
            }
        });
        static::deleted(function(Category $entity) {
            $entity->alterSiblingsPosition('decrement');
        });
    }

    public function items()
    {
        return $this->hasMany('\Menu\Item', 'category_id');
    }

    public function setPositionAttribute($value)
    {
        $maxPosition = Category::count();

        if (!$this->id)
            $maxPosition++;

        if ($value > $maxPosition)
            $value = $maxPosition;

        if ($value < 1)
            $value = 1;

        $this->attributes['position'] = $value;
    }

    private function alterSiblingsPosition($method, $useOriginal = false, $condition = '>=') {
        $position = $useOriginal ? $this->original['position'] : $this->position;

        $query = Category::where('position', $condition, $position)->where('id', '!=', $this->id);
        $result = $query->get();
        foreach($result as $row)
            $row->$method('position');
    }

}