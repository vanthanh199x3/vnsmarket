<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $connection = 'dbcenter';
    protected $guarded = [];

    public function url() {
        $protocol = request()->secure() ? 'https://' : 'http://';
        $domain = $this->shop_domain.'.'.$this->base_domain ;
        $appURL = $protocol.$domain;
        return $appURL;
    }
}
