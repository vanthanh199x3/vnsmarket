<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Transaction extends Model
{
    protected $connection = 'dbcenter';
    
    protected $guarded = [];

    protected $appends = ['from_email', 'to_email'];

    public function getFromEmailAttribute()
    {
        $user = User::find($this->from);
        return $this->attributes['from_email'] = $user->email ?? '';
    }

    public function getToEmailAttribute()
    {
        $user = User::find($this->to);
        return $this->attributes['to_email'] = $user->email ?? '';
    }

    public function wallet() {
        return $this->hasOne(Wallet::class, 'id', 'wallet_id');
    }

    public function withdraᴡUserBank() {
        $user = User::find($this->from);
        $bank = Bank::where('user_id', $user->id)->first();
        return $bank ?? array();
    }
}
