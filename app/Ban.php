<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function type() {
        return $this->belongsTo('App\BanType');
    }

    public function unban() {
        return $this->hasOne('App\Unban');
    }
}
