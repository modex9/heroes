<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'email', 'password', 'referrer', 'referralID', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function logins() {
        return $this->hasMany('App\Login');
    }

    public function bans() {
        return $this->hasMany('App\Ban');
    }

    public function hero() {
        return $this->belongsTo('App\Hero');
    }

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function isAdmin() {
        return $this->role->name == 'admin';
    }

    public function isBanned() {
        if($this->bans->count() == 0 || !$this->bans->last()->banIsValid())
            return false;
        $ban = $this->bans->last();
        $bandEndsSeconds =  strtotime($ban->created_at) + $ban->duration * 3600 - strtotime('now') - 3600*3;
        return $bandEndsSeconds > 0;
    }

    public static function getRules($user = null) {
        $rules = [
            'nickname' => [
                'required',
                'min:4',
                'max:15',
            ],
            'email' => [
                'required',
                'max:50',
                'email',
            ],
            'role' => 'integer|between:1,3|required',
            'id' => 'integer',
        ];
        if($user)
            $rules['nickname'][] = $rules['email'][] = Rule::unique('users')->ignore($user->id);

        return $rules;
    }

}
