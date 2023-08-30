<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class TransactionToken extends Model
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
}
