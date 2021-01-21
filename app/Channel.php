<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    // Relationships
    public function threads()
    {
        return $this->hasMany('App\Thread');
    }
}
