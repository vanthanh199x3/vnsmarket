<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscribeMetaDSVCom extends Model
{
    protected $table = "subscribes_metadsv_com";
    protected $fillable=['name','email'];
    public $timestamps = false;
}
