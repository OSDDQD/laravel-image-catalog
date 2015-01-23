<?php

namespace Guestbook;

use \BaseModel;

class Message extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'guestbook';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['displayname', 'text', 'ip', 'is_visible'];

    protected static $rules = [
        'user_id' => '',
        'displayname' => 'required',
        'text' => 'required|max:500',
    ];


    public function user()
    {
        return $this->hasOne('\User');
    }

}