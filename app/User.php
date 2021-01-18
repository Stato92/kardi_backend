<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SearchableTrait;
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'surname' => 10,
        ]
    ];
    public function patients() {
        return $this->hasMany('App\Patient');
    }
    public function statuses() {
        return $this->hasMany('App\Status');
    }
    public function eventComments() {
        return $this->hasMany('App\EventComment');
    }
    public function patientComments() {
        return $this->hasMany('App\PatientComment');
    }
    public function statusComments() {
        return $this->hasMany('App\StatusComment');
    }
    public function uploadedFiles() {
        return $this->hasMany('App\UploadedFile');
    }
    public function events() {
        return $this->belongsToMany('App\Event', 'event_users');
    }
    public function linkedSocialAccounts()
    {
        return $this->hasMany('App\LinkedSocialAccount');
    }

}
