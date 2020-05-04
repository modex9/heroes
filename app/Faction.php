<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    public $timestamps = false;

    protected $fillable = [
      'name', 'picture', 'description'
    ];

    public function heroes() {
        return $this->hasMany('App\Hero');
    }
}
