<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{

    protected $fillable = [
        'name', 'description'
    ];


    public function users() {
        return $this->hasMany('App\User');
    }
}
