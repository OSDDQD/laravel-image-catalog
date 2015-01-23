<?php

class Component extends Eloquent
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'components';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $value);
    }

    public static function getList()
    {
        $list = [];
        $components = self::orderBy('name')->get();
        foreach($components as $component) {
            $list[$component->name] = Lang::get('components.' . $component->name . '._title');
        }
        return $list;
    }

}