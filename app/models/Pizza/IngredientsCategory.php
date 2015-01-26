<?php

namespace Pizza;

use \Basic\TranslatableTrait;

class IngredientsCategory extends \BaseModel
{
    use TranslatableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ingredients_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'is_visible'];

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

    public function ingredients()
    {
        return $this->hasMany('\Pizza\Ingredient');
    }

}