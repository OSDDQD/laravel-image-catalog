<?php

namespace Pizza;


class Recipe extends \BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recipes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];

    protected static $rules = [
        'title' => 'required|min:3|max:35|unique:recipes,title',
        'description' => 'required|min:5|max:1000'
    ];

}