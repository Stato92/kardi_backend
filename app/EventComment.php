<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventComment extends Model
{
    protected $guarded = [];
    protected $table = 'event_comments';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
