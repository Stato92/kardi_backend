<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Event extends Model
{
    use SearchableTrait;
    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'date' => 10,
        ]
    ];
    public function patient() {
        return $this->belongsTo('App\Patient');
    }
    public function users() {
        return $this->belongsToMany('App\User', 'event_users');
    }
    public function comments()
    {
        return $this->hasMany('App\EventComment');
    }
    public function eventType() {
        return $this->belongsTo('App\EventType');
    }
}
