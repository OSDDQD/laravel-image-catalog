<?php

class BaseModel extends Eloquent
{

    protected static $rules = [];

    protected $errors;

    /**
     * Boot the application's service providers.
     *
     * @return void
     * @static
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($entity) {
            return $entity->validate();
        });
    }

    public function validate()
    {
        $validation = Validator::make($this->getAttributes(), static::$rules);

        if ($validation->fails()) {
            $this->errors = $validation->messages();
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}