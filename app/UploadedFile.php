<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    protected $guarded = [];
    public function patient() {
        return $this->belongsTo('App\Patient');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }

}
