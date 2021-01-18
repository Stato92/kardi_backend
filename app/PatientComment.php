<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientComment extends Model
{
    protected $guarded = [];
    protected $table = 'patient_comments';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
