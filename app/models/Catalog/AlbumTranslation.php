<?php

namespace Catalog;

class AlbumTranslation extends \Eloquent {


    public function category()
    {
        return $this->belongsTo('\Catalog\CategoryTranslation');
    }

    public function images()
    {
        return $this->hasMany('\Catalog\Image');
    }


    protected static $rules = [
        'title' => 'required',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catalog_albums_translations';

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