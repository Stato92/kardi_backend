<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = [];
    protected $table = 'statuses';

    public function patient() {
        return $this->belongsTo('App\Patient','patient_id','id');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function comments() {
        return $this->hasMany('App\StatusComment');
    }

}
