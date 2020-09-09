<?php

namespace App;

use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['user:id,name', 'favorites:id,favoritable_id,user_id'];
    
    // Accessors
    public function getCreatedAtAttribute(string $time): string
    {
        return Carbon::parse($time)->diffForHumans();
    }

    // Relationships
    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
