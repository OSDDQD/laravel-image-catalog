<?php

class MaterialTranslation extends BaseModel
{

    protected static $rules = [
        'title' => 'required',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'materials_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'text'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}