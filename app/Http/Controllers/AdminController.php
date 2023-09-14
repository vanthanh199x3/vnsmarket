<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use App\User;

use App\Rules\MatchOldPassword;

use Hash;

use Auth;

use Carbon\Carbon;

use App\Models\Settings;

use App\Models\Wallet;

use App\Models\UserWallet;

use App\Models\Order;

use App\Models\RollCall;



class AdminController extends Controller

{

    public function index() {

        $user = Auth::user();



        $orders = Order::select('total_amount')->whereYear('created_at', Carbon::now()->year)->get()->groupBy(function($d) {

            return Carbon::parse($d->created_at)->format('n');

        });

        $revenueOrders = [];

        for($i = 1; $i <= 12; $i++){

            $total = 0;

            if (isset($orders[$i])) {

                foreach($orders[$i] as $order) {

                    $total = $total + $order->total_amount;

                }

            }

            $revenueOrders[$i] = $total;

        }



        //làm giả dữ liệu

        $revenueOrders[4] = 35000000;

        $revenueOrders[5] = 82000000;

        $revenueOrders[6] = 208000000;

        $revenueOrders[7] = 232000000;

        $revenueOrders[8] = 278000000;
        $revenueOrders[9] = 164327300;
        //kết thúc là giải dữ liệu



        $users = User::whereYear('created_at', Carbon::now()->year)->get()->groupBy(function($d) {

            return Carbon::parse($d->created_at)->format('n');

        });

        $newUsers = [];

        for($i = 1; $i <= 12; $i++){

            $total = 0;

            if (isset($users[$i])) {

                foreach($users[$i] as $item) {

                    $total = $total + 1;

                }

            }

            $newUsers[$i] = $total;

        }



        //làm giả dữ liệu

        $newUsers[4] = 92;

        $newUsers[5] = 157;

        $newUsers[6] = 196;

        $newUsers[7] = 75+211;

        $newUsers[8] = 175+211;
        $newUsers[9] = 149;



        //kết thúc là giải dữ liệu



        $referrers = User::where('referrer', $user->id)->orderBy('id', 'DESC')->paginate(10);

        $totalRollCall = RollCall::where(['user_id' => $user->id])->count();

        $todayTotalRollCall = RollCall::whereDate('created_at', date('Y-m-d'))->count();

        $userWallets = UserWallet::where('user_id', $user->id)->get();

        $policySeller = Wallet::find(1)->policy();

        $policyRollCall = Wallet::find(2)->policy();

        return view('backend.index', compact('revenueOrders', 'newUsers', 'referrers', 'userWallets', 'totalRollCall', 'policySeller', 'policyRollCall', 'todayTotalRollCall'));

    }



    public function profile(){

        $profile = Auth()->user();

        return view('backend.users.profile')->with('profile',$profile);

    }



    public function profileUpdate(Request $request,$id){

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



        $status=$user->fill($data)->save();

        if($status){

            request()->session()->flash('success','Cập nhật thông tin thành công');

        }

        else{

            request()->session()->flash('error','Xin hãy thử lại!');

        }

        return redirect()->back();

    }





    public function settingLayout(Request $request) {

        $data = Settings::first();



        if($request->isMethod('post')) {

            $this->validate($request,[

                'short_des'=>'required|string',

                'shortcut'=>'required',

                'logo'=>'required',

                'address'=>'required|string',

                'email'=>'required|email',

            ]);



            $data = $request->except('files');

            $settings = Settings::first();

            $status = $settings->fill($data)->save();



            if($status){

                request()->session()->flash('success','Cập nhật cài đặt thành công');

            }

            else{

                request()->session()->flash('error','Xin hãy thử lại');

            }

            return redirect()->back();

        }



        return view('backend.setting.layout', compact('data'));

    }



    public function settingIntroduce(Request $request) {

        $data = Settings::first();



        if($request->isMethod('post')) {

            $this->validate($request,[

                'photo'=>'required',

                'description'=>'required|string',

                'youtube_video'=>'url|nullable',

            ]);



            $data = $request->except('files');

            $settings = Settings::first();

            $status = $settings->fill($data)->save();



            if($status){

                request()->session()->flash('success','Cập nhật cài đặt thành công');

            }

            else{

                request()->session()->flash('error','Xin hãy thử lại');

            }

            return redirect()->back();

        }



        return view('backend.setting.introduce', compact('data'));

    }



    public function settingSocial(Request $request) {

        $data = Settings::first();



        if($request->isMethod('post')) {

            $this->validate($request,[

                'facebook'=>'url|nullable',

                'zalo'=>'url|nullable',

                'youtube'=>'url|nullable',

                'instagram'=>'url|nullable',

                'tiktok'=>'url|nullable',

            ]);



            $data = $request->except('files');

            $settings = Settings::first();

            $status = $settings->fill($data)->save();



            if($status){

                request()->session()->flash('success','Cập nhật cài đặt thành công');

            }

            else{

                request()->session()->flash('error','Xin hãy thử lại');

            }

            return redirect()->back();

        }



        return view('backend.setting.social', compact('data'));

    }



    public function settingPayment(Request $request) {



        if($request->isMethod('post')) {

            $this->validate($request,[

                'default_wallet'=>'required',

                'default_bank'=>'required',

            ]);



            $data = $request->except('files');

            $settings = Settings::first();

            $status = $settings->fill($data)->save();



            if($status){

                request()->session()->flash('success','Cập nhật cài đặt thành công');

            }

            else{

                request()->session()->flash('error','Xin hãy thử lại');

            }

            return redirect()->back();

        }



        $data = Settings::first();

        if (auth()->user()->role == 'admin') {

            $admins = User::where(['role' => 'admin', 'status' => 'active'])->get();

        }

        return view('backend.setting.payment', compact('data', 'admins'));

    }



    public function settings() {

        $data = Settings::first();



        if (auth()->user()->role == 'admin') {

            $admins = User::where(['role' => 'admin', 'status' => 'active'])->get();

        }

        if (auth()->user()->role == 'shop') {

            $admins = User::where(['id' => auth()->user()->id])->get();

        }



        return view('backend.setting', compact('data', 'admins'));

    }



    public function settingsUpdate(Request $request){

        // return $request->all();

        $this->validate($request,[

            'short_des'=>'required|string',

            'description'=>'required|string',

            'photo'=>'required',

            'shortcut'=>'required',

            'logo'=>'required',

            'address'=>'required|string',

            'email'=>'required|email',

            'phone'=>'required|string',

            'facebook'=>'url|nullable',

            'zalo'=>'url|nullable',

            'youtube'=>'url|nullable',

            'instagram'=>'url|nullable',

            'tiktok'=>'url|nullable',

            'default_wallet'=>'required',

            'default_bank'=>'required',

        ]);



        $data = $request->except('files');

        $settings = Settings::first();

        $status = $settings->fill($data)->save();



        if($status){

            request()->session()->flash('success','Cập nhật cài đặt thành công');

        }

        else{

            request()->session()->flash('error','Xin hãy thử lại');

        }

        return redirect()->back();

    }



    public function changePassword(){

        return view('backend.layouts.changePassword');

    }



    public function changPasswordStore(Request $request)

    {

        $request->validate([

            'current_password' => ['required', new MatchOldPassword],

            'new_password' => ['required'],

            'new_confirm_password' => ['same:new_password'],

        ]);



        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);



        return redirect()->route('admin')->with('success','Thay đổi mật khẩu thành công');

    }



    // Pie chart

    public function userPieChart(Request $request){

        // dd($request->all());

        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))

        ->where('created_at', '>', Carbon::today()->subDay(6))

        ->groupBy('day_name','day')

        ->orderBy('day')

        ->get();

     $array[] = ['Name', 'Number'];

     foreach($data as $key => $value)

     {

       $array[++$key] = [$value->day_name, $value->count];

     }

    //  return $data;

     return view('backend.index')->with('course', json_encode($array));

    }



    // public function activity(){

    //     return Activity::all();

    //     $activity= Activity::all();

    //     return view('backend.layouts.activity')->with('activities',$activity);

    // }



    public function rollCall() {

        $user = Auth::user();

        $total = RollCall::where(['user_id' => $user->id])->count();

        return view('backend.rollcall.index', compact('total'));

    }



    public function addRollCall() {

        $user = Auth::user();

        $recently = RollCall::where(['user_id' => $user->id])->orderBy('created_at', 'desc')->first();



        $result['status'] = false;



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

                }

            } else {

                $result['message'] = "Bạn đã điểm danh hôm nay rồi!";

            }

        }



        return response()->json($result);

    }



}

