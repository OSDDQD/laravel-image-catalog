<?php

namespace Pizza;

use \Basic\TranslatableTrait;

class Pizza extends \BaseModel
{
    use TranslatableTrait;

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
    protected $fillable = ['title', 'description', 'is_visible', 'max_weight', 'size'];

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

    public function options()
    {
        return $this->hasMany('\Pizza\Option');
    }

    public function setMaxWeightAttribute($value)
    {
        $this->attributes['max_weight'] = floatval(preg_replace('/[^\d.]/', '', $value));
    }

    public function setSizeAttribute($value)
    {
        $this->attributes['size'] = floatval(preg_replace('/[^\d.]/', '', $value));
    }

}