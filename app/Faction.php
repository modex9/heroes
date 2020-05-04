<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    public function heroes() {
        return $this->hasMany('App\Hero');
    }
}
