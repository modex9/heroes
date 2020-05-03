<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $fillable = [
        'user', 'ip', 'platform'
    ];

    protected function user() {
        return $this->belongsTo('App\User');
    }
}
