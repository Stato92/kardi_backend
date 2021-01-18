<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Patient extends Model
{
    use SearchableTrait;
    protected $guarded = [];
    protected $casts = [
        'is_alive' => 'boolean',
    ];
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'surname' => 10,
            'pesel' => 5,
            'phone_numbers' => 5,
        ]
    ];
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function statuses() {
        return $this->hasMany('App\Status');
    }
    public function events() {
        return $this->hasMany('App\Event');
    }
    public function comments() {
        return $this->hasMany('App\PatientComment');
    }
    public function diseases() {
        return $this->belongsToMany('App\Disease', 'patient_diseases');
    }
    public function uploadedFiles() {
        return $this->hasMany('App\UploadedFile');
    }
}
