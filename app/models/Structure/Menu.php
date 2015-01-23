<?php

namespace Structure;

use \Basic\TranslatableTrait;

class Menu extends \BaseModel
{
    use TranslatableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'title'];

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

    protected static $rules = [
        'slug' => 'required',
    ];

    public function pages()
    {
        return $this->hasMany('\Structure\Page');
    }

}