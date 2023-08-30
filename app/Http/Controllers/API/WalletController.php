<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\User;
use App\Models\Wallet;
use App\Models\UserWallet;

class WalletController extends Controller
{
    public function balance() {
        $userWallets = UserWallet::where(['user_id' => Auth::user()->id])->get();
        if (!empty($userWallets)) {
            foreach($userWallets as $wallet) {
                $wallet->wallet_name = $wallet->wallet->name;
                unset($wallet->id);
                unset($wallet->user_id);
                unset($wallet->wallet);
            }
            return $this->successResponse($userWallets);
        } else {
            return $this->errorResponse('Not found user wallet!');
        }
    }

    public function policy($walletId) {
        $wallet = Wallet::find($walletId);
        if(!empty($wallet)) {
            return $this->successResponse($wallet);
        } else {
            return $this->errorResponse('Not found wallet!');
        }
    }
}
