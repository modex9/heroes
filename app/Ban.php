<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'type_id', 'reason', 'duration', 'issuer'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function getBannedUntilDate() {
        return gmdate("Y-m-d H:i:s", strtotime($this->created_at) + $this->duration * 3600);
    }

    public function getBanEndsIn() {
        $now = date_create(date("Y-m-d H:i:s", strtotime('now') + 3600*3));
        $banned_until = date_create($this->getBannedUntilDate());
        $banEndsIn = date_diff($now, $banned_until);
        $format = "";
        if($banEndsIn->d > 0)
            $format .= "%a dienos ";
        if($banEndsIn->h > 0)
            $format .= "%h valandos ";
        if($banEndsIn->i > 0 || $banEndsIn->h > 0)
            $format .= "%i minutės ";
        if($banEndsIn->s > 0 || $banEndsIn->i > 0)
            $format .= "%s sekundės.";
        return $banEndsIn->format($format);
    }

    public function type() {
        return $this->belongsTo('App\BanType');
    }

    public function unban() {
        return $this->hasOne('App\Unban');
    }

    public function banIsValid() {
        return is_null($this->unban);
    }
}
