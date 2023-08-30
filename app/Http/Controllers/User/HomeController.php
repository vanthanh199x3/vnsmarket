<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\MatchOldPassword;
use Hash;
use Auth;
use Carbon\Carbon;
use App\User;
use App\Models\Wallet;
use App\Models\UserWallet;
use App\Models\RollCall;
use App\Models\Order;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();
        $referrers = User::where('referrer', $user->id)->orderBy('id', 'DESC')->paginate(10);
        $totalRollCall = RollCall::where(['user_id' => $user->id])->count();
        $userWallets = UserWallet::where('user_id', $user->id)->get();
        $policySeller = Wallet::find(1)->policy();
        $policyRollCall = Wallet::find(2)->policy();

        $orders = Order::select('id')->whereYear('created_at', Carbon::now()->year)->get()->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('n');
        });

        $countOrders = [];
        $commissions = [];
        for($i = 1; $i <= 12; $i++){
            $total = 0;
            $commissions = 0;
            if (isset($orders[$i])) {
                foreach($orders[$i] as $order) {
                    $total = $total + 1;
                    if ($order->status == 'delivered') {
                        $commissions = $commissions + $order->bonus();
                    }
                }
            }
            $countOrders[$i] = $total;
        }

        return view('user.index', compact('userWallets', 'totalRollCall', 'referrers', 'policySeller', 'policyRollCall', 'countOrders', 'commissions'));
    }

    public function profile(){
        $profile = Auth()->user();
        return view('user.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request, $id){

        $user = User::findOrFail($id);

        $this->validate($request,
        [
            'name'=>'string|required|min:3|max:50',
            'phone'=> ['numeric', 'nullable', Rule::unique('users')->ignore($user->id)],
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'photo' => $request->photo,
        ];
        $status = $user->fill($data)->save();

        if($status){
            request()->session()->flash('success','Cập nhật thông tin tài khoản thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->back();
    }

    public function changePassword(){
        return view('user.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('user')->with('success','Thay đổi mật khẩu thành công');
    }

    public function rollCall() {
        $user = Auth::user();
        $total = RollCall::where(['user_id' => $user->id])->count();
        return view('user.rollcall.index', compact('total'));
    }

    public function addRollCall() {
        $user = Auth::user();
        $recently = RollCall::where(['user_id' => $user->id])->orderBy('created_at', 'desc')->first();
        
        $result['status'] = false;
        $bonusToken = 1000;

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

                $result['status'] = true;
                $result['token'] = number_format($DSVCoin->money, 2);
                $result['message'] = "Điểm danh thành công, nhận được {$token} token";

                // Bounus 1k token
                // if ($user->identifier == 1) {
                //     $countRollcall = RollCall::select('id')->where(['user_id' => $user->id])->count();
                //     if ($countRollcall == 10) {
                //         $DSVCoin->money = floatval($DSVCoin->money) + floatval($bonusToken);
                //         $DSVCoin->save();
                //         $result['token'] = number_format($DSVCoin->money, 2);
                //         $result['message'] .= "\r\nBạn đã được tặng 1,000 DSV Token";
                //     }
                // }
            } else {
                $result['message'] = "Điểm danh thất bại, xin hãy thử lại";
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

                    $result['status'] = true;
                    $result['token'] = number_format($DSVCoin->money, 2);
                    $result['message'] = "Điểm danh thành công, nhận được {$token} token";

                    // Bounus 1k token
                    // if ($user->identifier == 1) {
                    //     $countRollcall = RollCall::select('id')->where(['user_id' => $user->id])->count();
                    //     if ($countRollcall == 10) {
                    //         $DSVCoin->money = floatval($DSVCoin->money) + floatval($bonusToken);
                    //         $DSVCoin->save();
                    //         $result['token'] = number_format($DSVCoin->money, 2);
                    //         $result['message'] .= "\r\nBạn đã được tặng 1,000 DSV Token";
                    //     }
                    // }
                }
            } else {
                $result['message'] = "Bạn đã điểm danh hôm nay rồi!";
            }
        }

        return response()->json($result);
    }
}
