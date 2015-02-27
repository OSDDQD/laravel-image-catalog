<?php

namespace Menu;

class ItemTranslation extends \BaseModel
{

    protected static $rules = [
        'title' => 'required',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_items_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}