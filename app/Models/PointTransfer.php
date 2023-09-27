<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransfer extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'sender_id', 'receiver_id', 'amount'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'PointTransfer';
}
