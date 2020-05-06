<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unban extends Model
{
    public function ban() {
        return $this->belongsTo('App\Ban');
    }
}
