<?php

namespace Menu;

use Basic\PositionedTrait;
use \Basic\TranslatableTrait;

class Item extends \BaseModel
{
    use TranslatableTrait,
        PositionedTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['position', 'category_id', 'title', 'description', 'is_visible', 'is_novelty', 'is_popular', 'price', 'image'];

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

        static::created(function(Item $entity) {
            $entity->alterSiblingsPosition('increment');
        });

        static::updating(function(Item $entity) {
            if ($entity->isDirty('category_id') or $entity->isDirty('position')) {
                $entity->alterSiblingsPosition('decrement', true);
                $entity->alterSiblingsPosition('increment');
            }
        });

        static::deleted(function(Item $entity) {
            $entity->alterSiblingsPosition('decrement');
        });
    }

    public function category()
    {
        return $this->belongsTo('\Menu\Category');
    }

    public function setPositionAttribute($value)
    {
        if (!$this->id) {
            $this->attributes['position'] = $value;
        } else {
            $maxPosition = Item::whereCategoryId($this->category_id)->count();

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

        $query = Item::whereCategoryId($categoryId);
        $query->where('position', $condition, $position)->where('id', '!=', $this->id);
        $result = $query->get();
        foreach($result as $row)
            $row->$method('position');
    }

}