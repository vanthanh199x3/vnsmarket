<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Models\Setting;
// use App\Models\Bank;

class Bank extends Model
{
    protected $guarded = [];

    protected $connection = 'dbcenter';

    public static function defaultShopBank() {

        $bank = NULL;
        $setting = Settings::first();

        if ($setting->default_bank != '') {
            $bank = Bank::where(['user_id' => $setting->default_bank])->first();
        }
        
        return $bank;
    }

    public static function masterShopBank() {
        $bank = NULL;
        $setting = Settings::on('dbcenter')->first();

        if ($setting->default_bank != '') {
            $bank = Bank::on('dbcenter')->where(['user_id' => $setting->default_bank])->first();
        }
        return $bank;
    }
}
