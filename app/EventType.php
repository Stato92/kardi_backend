<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $guarded = [];
    protected $visible = ['id','name'];
    public $timestamps = false;
    protected $table = 'event_types';
    public function events() {
        return $this->hasMany('App\Event');
    }
}
