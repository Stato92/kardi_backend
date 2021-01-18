<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Disease extends Model
{
    use SearchableTrait;
    protected $guarded = [];
    protected $table = 'diseases';
    public $timestamps = false;
    protected $visible = ['name'];
    protected $searchable = [
        'columns' => [
            'name' => 10,
        ]
    ];
    public function patients() {
        return $this->belongsToMany('App\Patient', 'patient_diseases');
    }
}
