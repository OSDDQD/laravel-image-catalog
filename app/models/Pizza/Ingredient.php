<?php

namespace Pizza;

use \Basic\TranslatableTrait;

class Ingredient extends \BaseModel
{
    use TranslatableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ingredients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'title', 'description', 'is_visible'];

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

    public function category()
    {
        return $this->hasOne('\Pizza\IngredientsCategory');
    }

//    public function ingredients()
//    {
//        return $this->hasMany('\Structure\Page');
//    }

}