<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusComment extends Model
{
    protected $guarded = [];
    protected $table = 'status_comments';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
