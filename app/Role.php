<?php

namespace App;

class Role extends Model
{
    public function users()
    {
    	return $this->hasMany(User::class);
    }
}
