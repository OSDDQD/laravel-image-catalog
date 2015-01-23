<?php

class Setting extends Eloquent
{

    const TYPE_LOCALIZED = 'localized';
    const TYPE_SERIALIZED = 'serialized';
    const TYPE_TEXT = 'text';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'value', 'locale'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function getOrderedArray()
    {
        $array = [];
        $settings = self::orderBy('name')->get();
        foreach($settings as $setting) {
            $array[$setting->id] = [
                'label' => Lang::get('settings.' . $setting->name . '._title'),
                'value' => $setting->value,
            ];
        }
        return $array;
    }

}