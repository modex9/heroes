<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'description', 'picture', 'faction_id'
    ];

    public function users() {
        return $this->hasMany('App\User');
    }

    public function faction() {
        return $this->belongsTo('App\Faction');
    }
}
