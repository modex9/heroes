<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BanType extends Model
{
    public $timestamps = false;

    public function bans() {
        return $this->hasMany('App\Ban');
    }
}
