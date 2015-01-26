<?php

namespace Pizza;

class IngredientsCategoryTranslation extends \BaseModel
{

    protected static $rules = [
        'title' => 'required',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ingredients_categories_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}