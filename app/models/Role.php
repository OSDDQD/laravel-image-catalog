<?php

class Role extends Eloquent
{

    const ROLE_GUEST = 'guest';
    const ROLE_MASTER_ADMIN = 'master-admin';
    const ROLE_USER = 'user';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('User', 'users_roles');
    }

}