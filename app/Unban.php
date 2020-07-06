<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unban extends Model
{
    public $timestamps = false;

    protected $fillable = ['reason', 'ban_id', 'issuer'];

    public function ban() {
        return $this->belongsTo('App\Ban');
    }

    public static function getRules() {
        return [
            'reason' => 'min:5|max:200|required',
       ];
   }
}
