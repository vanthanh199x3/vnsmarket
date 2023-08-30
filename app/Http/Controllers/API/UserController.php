<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RollCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\User;
use App\Models\Wallet;
use App\Models\UserWallet;
use App\Models\SubscribeMetaDSVCom;

class UserController extends Controller
{

    public function login() { 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $token = $user->createToken('Mobile App');
            $data['token'] = $token->accessToken;
            $data['expires_at'] = $token->token->expires_at->format('Y-m-d H:i:s');
            return $this->successResponse($data);
        } 
        else{
            return $this->errorResponse('Unauthorised');
        } 
    }
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'string|required|min:3|max:50', 
            'email' => 'email|required|unique:users', 
            'phone' => 'numeric|nullable|unique:users', 
            'password' => 'required|min:6', 
            'password_confirmation' => 'required|same:password', 
            'referrer' => 'nullable|email|exists:users,email',
        ]);

        if ($validator->fails()) { 
            //return $this->errorResponse($validator->errors());     
            return response()->json($this->errorResponse($validator->errors()), 200);
        }

        $input = $request->all(); 
        $input['password'] = Hash::make($input['password']);
        $input['role'] = 'user';
        if ($input['referrer'] != '') {
            $referrer = User::where('email', $input['referrer'])->first();
            $input['referrer'] = $referrer->id;
        }

        $user = User::create($input);
        if ($user) {
            // create default wallet
            $wallets = Wallet::all();
            foreach($wallets as $wallet) {
                UserWallet::create([
                    'user_id' => $user->id,
                    'wallet_id' => $wallet->id,
                    'status' => 1,
                ]);
            }
        }

        $token= $user->createToken('Mobile App'); 
        $data['token'] = $token->accessToken;
        $data['expires_at'] = $token->token->expires_at->format('Y-m-d H:i:s');
        $data['name'] = $user->name;
        $data['email'] = $user->email;

        return $this->successResponse($data);
    }

    public function profile() 
    { 
        $user = Auth::user();
        $user->affiliate_link = route('register.form', ['r' => \Helper::setReferrer($user->id)]); 
        return $this->successResponse($user);
    }

    public function addRollCall(Request $request) {
        $user = Auth::user();
        // test
        // $DSVCoin = UserWallet::where(['wallet_id' => 2,'user_id' => $user->id])->first();
        // $DSVCoin->updateWalletReferrers(10);
        // end test
        $today = RollCall::where(['user_id' => $user->id, 'date' => date('Y-m-d')])->first();
        $token = 0;
        if(empty($today) ) {
            
            $status = RollCall::create(['user_id' => $user->id, 'date' => date('Y-m-d')]);
            
            if ($status) {
                $DSVCoin = UserWallet::where(['wallet_id' => 2,'user_id' => $user->id])->first();
                if (empty($DSVCoin)) {
                    $DSVCoin = UserWallet::create([
                        'user_id' => $user->id,
                        'wallet_id' => 2,
                        'status' => 1,
                    ]);
                }

                $token = $DSVCoin->wallet->click_rollcall;
                $DSVCoin->money = floatval($DSVCoin->money) + floatval($token);
                $DSVCoin->save();
                $DSVCoin->updateWalletReferrers($token);
            }
            
        }

        $total = RollCall::where(['user_id' => $user->id])->count();
        $recently = RollCall::where(['user_id' => $user->id])->orderBy('created_at', 'desc')->first();
        return $this->successResponse([
            'total' => $total, 
            'today' => true, 
            'token' => $token,
            'recently' => $recently->created_at->format('Y-m-d H:i:s') ?? NULL
        ]);
    }

    public function totalRollCall() {
        $user = Auth::user();
        $recently = RollCall::where(['user_id' => $user->id])->orderBy('created_at', 'desc')->first();
        $total = RollCall::where(['user_id' => $user->id])->count();
        return $this->successResponse([
            'total' => $total, 
            'recently' => $recently->created_at->format('Y-m-d H:i:s') ?? NULL, 
        ]);
    }

    // current public
    public function rollcall(Request $request) {
        $user = Auth::user();
        $recently = RollCall::where(['user_id' => $user->id])->orderBy('created_at', 'desc')->first();
        $token = 0;
        if(empty($recently) ) {
            $recently = RollCall::create(['user_id' => $user->id, 'date' => date('Y-m-d')]);
            if ($recently) {
                $DSVCoin = UserWallet::where(['wallet_id' => 2,'user_id' => $user->id])->first();
                if (empty($DSVCoin)) {
                    $DSVCoin = UserWallet::create([
                        'user_id' => $user->id,
                        'wallet_id' => 2,
                        'status' => 1,
                    ]);
                }
                $token = $DSVCoin->wallet->click_rollcall;
                $DSVCoin->money = floatval($DSVCoin->money) + floatval($token);
                $DSVCoin->save();
                $DSVCoin->updateWalletReferrers($token);
            }
        } else {
            if (strtotime('-1 day') > strtotime($recently->created_at)) {
                $recently = RollCall::create(['user_id' => $user->id, 'date' => date('Y-m-d')]);
                if ($recently) {
                    $DSVCoin = UserWallet::where(['wallet_id' => 2,'user_id' => $user->id])->first();
                    if (empty($DSVCoin)) {
                        $DSVCoin = UserWallet::create([
                            'user_id' => $user->id,
                            'wallet_id' => 2,
                            'status' => 1,
                        ]);
                    }
                    $token = $DSVCoin->wallet->click_rollcall;
                    $DSVCoin->money = floatval($DSVCoin->money) + floatval($token);
                    $DSVCoin->save();
                    $DSVCoin->updateWalletReferrers($token);
                }
            }
        }

        $total = RollCall::where(['user_id' => $user->id])->count();
        return $this->successResponse([
            'total' => $total,
            'token' => $token,
            'recently' => $recently->created_at->format('Y-m-d H:i:s') ?? NULL
        ]);
    }
    
    public function subscribe_metadsv_com(Request $request) 
    { 
        $input = $validator = Validator::make($request->all(), [ 
            'name' => 'string|required|min:3|max:50', 
            'email' => 'email|required', 
        ]);

        if ($validator->fails()) { 
            return $this->errorResponse($validator->errors());     
            // return response()->json($this->errorResponse($validator->errors()), 200);
        }

        $subscribe = new SubscribeMetaDSVCom();
        $subscribe->name = $request->name;
        $subscribe->email = $request->email;
         $subscribe->save();

        $data['name'] = $subscribe->name;
        $data['email'] = $subscribe->email;

        return $this->successResponse($data);
    }

}
