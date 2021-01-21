<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];
    protected $perPage = 25;

    // Relationships
    public function subject()
    {
        return $this->morphTo();
    }

    // Accessors
    public function getCreatedAtAttribute(string $time): string
    {
        return Carbon::parse($time)->diffForHumans();
    }
}
