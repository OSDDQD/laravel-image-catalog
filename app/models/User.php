<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Basic\SEOTrait;

class User extends BaseModel implements UserInterface, RemindableInterface
{

	use UserTrait,
        RemindableTrait,
        SEOTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password', 'displayname', 'email', 'birthday', 'is_female', 'roles'];

    protected $appends = ['roles'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    protected static $rules = [
        'username' => 'required|min:3|max:25|unique:users,username',
        'displayname' => 'required',
        'email' => 'required|email|unique:users,email',
        'birthday' => 'required|date',
    ];

    /**
     * Boot the application's service providers.
     *
     * @return void
     * @static
     */
    public static function boot()
    {
        static::saving(function(User $entity) {
            self::$rules['birthday'] .= '|before:'.date('Y-m-d');
            if ($entity->id) {
                self::$rules['username'] .= ',' . $entity->id;
                self::$rules['email'] .= ',' . $entity->id;
            } else {
                self::$rules['password'] = 'required';
            }
        });

        parent::boot();
    }

    /**
     * Update the model in the database.
     *
     * @param  array  $attributes
     * @return bool|int
     */
    public function update(array $attributes = [])
    {
        if (!isset($attributes['roles']))
            $attributes['roles'] = [];
        return parent::update($attributes);
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = self::makeSEOString($value);
    }

    public function setPasswordAttribute($value)
    {
        if ($value)
            $this->attributes['password'] = Hash::make($value);
    }

    public function transactions()
    {
        return $this->hasMany('Transaction');
    }

    public function roles()
    {
        return $this->belongsToMany('Role', 'users_roles');
    }

    public function guestbookMessages()
    {
        return $this->hasMany('Guestbook\Message');
    }

    public function setRolesAttribute($roles)
    {
        if (!is_array($roles))
            $roles = [];
        $this->roles()->sync(array_keys($roles), true);
    }

    public function setBirthdayAttribute($birthday)
    {
        $this->attributes['birthday'] = null;
        if (is_array($birthday)) {
            foreach ($birthday as $part => $value)
                $birthday[$part] = (int) $value;
            if (!isset($birthday['day']) or !$birthday['day']
                    or !isset($birthday['month']) or !$birthday['month']
                    or !isset($birthday['year']) or !$birthday['year'])
                return false;
            $this->attributes['birthday'] = date('Y-m-d', mktime(0, 0, 0, $birthday['month'], $birthday['day'], $birthday['year']));
        } else {
            $birthday = explode('-', $birthday);
            if (count($birthday) != 3)
                return false;
            $this->attributes['birthday'] = date('Y-m-d', mktime(0, 0, 0, $birthday[1], $birthday[2], $birthday[0]));
        }
    }

    public function setBalanceAttribute($value)
    {
        $this->attributes['balance'] = floatval(preg_replace('/[^\d.]/', '', $value));
    }

    public function hasRole($role)
    {
        return in_array($role, array_fetch($this->roles->toArray(), 'name'));
    }

    public function addRole($role)
    {
        if (!$role instanceof Role) {
            $role = Role::whereName($role)->first();
            if (!$role)
                throw new \Exception("Role not found.");
        }

        $this->roles()->save($role);
    }

    public function removeRole($role)
    {
        if (!$role instanceof Role) {
            $role = Role::whereName($role)->first();
            if (!$role)
                throw new \Exception("Role not found.");
        }

        $this->roles()->detach($role->id);
    }


}
