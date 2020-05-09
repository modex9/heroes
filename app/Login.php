<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'ip', 'platform'
    ];

    protected function user() {
        return $this->belongsTo('App\User');
    }
}
