<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $guarded = [];
    protected $table = 'chat_messages';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
