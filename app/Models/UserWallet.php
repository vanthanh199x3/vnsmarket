<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $connection = 'dbcenter';
    protected $guarded = [];

    public static function defaultShopWallet($walletID = NULL) {

        $shopWallet = NULL;
        $setting = Settings::first();
        $wallet = Wallet::find($walletID);

        if (!empty($wallet) && $setting->default_wallet != '') {

            $shopWallet = UserWallet::where(['user_id' => $setting->default_wallet, 'wallet_id' => $walletID])->first();
            
            if (empty($shopWallet)) {
                $shopWallet = UserWallet::create([
                    'user_id' => $setting->default_wallet,
                    'wallet_id' => $walletID,
                    'status' => 1,
                ]);
            }
        }
        
        return $shopWallet;
    }

    public static function masterShopWallet($walletID = NULL) {
        $shopWallet = NULL;
        $setting = Settings::on('dbcenter')->first();
        $wallet = Wallet::find($walletID);

        if (!empty($wallet) && $setting->default_wallet != '') {

            $shopWallet = UserWallet::where(['user_id' => $setting->default_wallet, 'wallet_id' => $walletID])->first();
            
            if (empty($shopWallet)) {
                $shopWallet = UserWallet::create([
                    'user_id' => $setting->default_wallet,
                    'wallet_id' => $walletID,
                    'status' => 1,
                ]);
            }
        }
        
        return $shopWallet;
    }

    public function wallet() {
        return $this->hasOne(Wallet::class,'id','wallet_id');
    }

    public function updateWalletReferrers($value = 0, $content = '') {

        $value = $this->wallet->is_token == 1 ? floatval($value) : (int) $value;

        if ($value <= 0) {
            return false;
        }

        if ($this->wallet_id == 1) {

            $user   = \App\User::find($this->user_id);
            $policy = $this->wallet->policy();

            if (!empty($policy)) {
                // Payment commission for sellser 
                if (!empty($policy['direct'])) {
                    if ($user->role != 'admin') {
                        $data = [
                            'from' => auth()->user()->id,
                            'to' => $user->id,
                            'type' => 3,
                            'money' => $value,
                            'wallet_id' => $this->wallet_id,
                            'content' => 'Thanh toán hoa hồng ('.$content.')'
                        ];
                        Wallet::transfer($data);
                    }
                }
                
                // Check user level only up to  (F1, F2, F3 internal)
                // $levelCheck = $user->depthReferrers();
                // if (count($levelCheck) <= 2) { 

                //     $filias = $user->depthReferrers(2);
                //     if (!empty($filias)) {

                //         foreach($filias as $key => $parent) {

                //             if ($parent->role != 'admin') {

                //                 if (array_key_exists($key, $policy['filia'])) {

                //                     $bonus = ($value * $policy['filia'][$key]) / 100;

                //                     $data = [
                //                         'from' => auth()->user()->id,
                //                         'to' => $parent->id,
                //                         'type' => 3,
                //                         'money' => $bonus,
                //                         'wallet_id' => $this->wallet_id,
                //                         'content' => 'Thanh toán hoa hồng ('.$user->email.')'
                //                     ];
                //                     Wallet::transfer($data);
                //                 }
                //             }
                //         }

                //     }
                // }
            }
        }

        // if ($this->wallet_id == 2) {

        //     $user   = \App\User::find($this->user_id);
        //     $filias = $user->depthReferrers();

        //     if (!empty($filias)) {

        //         $policy = $this->wallet->policy();

        //         if (!empty($policy)) {
                    
        //             foreach($filias as $key => $parent) {

        //                 if (array_key_exists($key, $policy['filia'])) {
        //                     // Check filia condition
        //                     if (!empty($policy['condition']['filia'])) {
        //                         foreach($policy['condition']['filia'] as $filia => $num) {
        //                             if ($key == $filia) {
        //                                 if($parent->referrers->count() < $num) {
        //                                     continue 2;
        //                                 }
        //                             }
        //                         }
        //                     }
                            
        //                     $userWallet = UserWallet::where(['user_id' => $parent->id, 'wallet_id' => $this->wallet_id])->first();
        //                     if (empty($userWallet)) {
        //                         $userWallet = UserWallet::create([
        //                             'user_id' => $parent->id,
        //                             'wallet_id' => $this->wallet_id ,
        //                             'status' => 1,
        //                         ]);
        //                     }

        //                     $bonus = ($value * $policy['filia'][$key]) / 100;
        //                     $userWallet->money = floatval($userWallet->money) + $bonus;
        //                     $userWallet->save();

        //                 }
        //             }
        //         }

        //     }
        // }
    }
}
