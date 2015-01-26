<?php

namespace Pizza;

use \Basic\TranslatableTrait;

class Option extends \BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pizzas_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pizza_id', 'ingredient_id', 'price', 'weight', 'max_quantity'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected static $rules = [];

    public function pizza()
    {
        return $this->hasOne('\Pizza\Pizza');
    }

    public function ingredient()
    {
        return $this->hasOne('\Pizza\Ingredient');
    }

}