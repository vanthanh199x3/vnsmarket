<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $connection = 'dbcenter';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','photo','status','provider','provider_id', 'referrer', 'phone', 'identifier', 'id_card_front', 'id_card_back', 'portrait', 'address'
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

    public function shop()
    {
        return $this->hasOne('App\Models\Shop', 'user_id');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function referrers(){
        return $this->hasMany('App\User','referrer','id');
    }

    public function parentReferrer()
    {
        return $this->belongsTo('App\User', 'referrer');
    }

    public function depthReferrers($level = 20) {
        $parents = [];
        $parent = $this->parentReferrer;
        $filia = 1;
        while(!is_null($parent)) {
            if ($filia >= ($level + 1)) {
                break;
            }
            $parents['F'.$filia] = $parent;
            $parent = $parent->parentReferrer;
            $filia ++;
        }
        
        return $parents;
    }

    public function rollcall() {
        return $this->hasMany('App\Models\RollCall');
    }

    public static function countActiveUser(){
        $data = \App\User::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
