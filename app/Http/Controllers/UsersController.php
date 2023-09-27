<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Wallet;
use App\Models\UserWallet;
use App\Models\Shop;
use App\Models\PointTransfer;

class UsersController extends Controller
{
    function __construct() {
    }

    public function index()
    {
        $users = User::where(['is_delete' => 0])->where('id', '<>', 1)->orderBy('id','ASC')->paginate(20);
        return view('backend.users.index')->with('users', $users);
    }

        public function transferPoints(Request $request)
        {
            // Xác định người gửi (admin)
            $admin = Auth::user();

            // Lấy thông tin người nhận và số điểm cần chuyển từ biểu mẫu
            $receiver_id = $request->input('receiver_id');
            $amount = $request->input('amount');

            // Tạo một bản ghi giao dịch
            PointTransfer::create([
                'sender_id' => $admin->id,
                'receiver_id' => $receiver_id,
                'amount' => $amount,
            ]);

            // Cập nhật số điểm cho người nhận
            $receiver = User::find($receiver_id);
            $receiver->increment('points', $amount);

            request()->session()->flash('success','Chuyển điểm thành công');
            return redirect()->route('users.index');
        }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name'=>'string|required|min:3|max:50',
            'email'=>'email|required|unique:users',
            'phone'=>'numeric|nullable|unique:users',
            'password'=>'required|min:6',
            'role'=>'required|in:admin,user,shop',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|string',
        ]);
        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $insert = User::create($data);
        if($insert){
            
            // create default wallet
            $wallets = Wallet::all();
            foreach($wallets as $wallet) {
                UserWallet::create([
                    'user_id' => $insert->id,
                    'wallet_id' => $wallet->id,
                    'status' => 1,
                ]);
            }

            request()->session()->flash('success','Thêm người dùng thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
        }
        return redirect()->route('users.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user=User::findOrFail($id);
        return view('backend.users.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $this->validate($request,
        [
            'name'=>'string|required|min:3|max:50',
            'email'=> ['email', 'required', Rule::unique('users')->ignore($user->id)],
            'phone'=> ['numeric', 'nullable', Rule::unique('users')->ignore($user->id)],
            'role'=>'required|in:admin,user,shop',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|string',
            'identifier'=>'nullable',
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Cập nhật người dùng thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
        }
        return redirect()->route('users.index');

    }

    public function destroy($id)
    {
        $user = User::findorFail($id);
        $user->is_delete = 1;
        $status = $user->save();
        
        if($status){
            request()->session()->flash('success','Xóa người dùng thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
        }
        return redirect()->route('users.index');
    }

    public function shopInfo($id) {
        $shopInfo = Shop::findOrFail($id);
        return view('backend.users.shop', compact('shopInfo'));
    }

    public function shopApproved(Request $request, $id) {
        $this->validate($request,[
            'shop_name'=>'required|max:200',
            'shop_domain'=>'required|regex:/^[a-z][a-z0-9]+$/i',
            'shop_phone'=>'required',
        ]);

        $data = $request->except('_token');
        $shop = Shop::find($id);
        if($request->status == '1' && $shop->env == '') {
            $data['env'] = $this->shopInitialize($shop);
        }

        if($shop->update($data)){
            User::find($shop->user_id)->update(['role' => 'shop']);
            request()->session()->flash('success', 'Cập nhật cửa hàng thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->back();
    }

    public function shopInitialize($shop) {

        if (!empty($shop)) {

            $domain = $dbDatabase = $dbUsername = $shop->shop_domain.'.'.$shop->base_domain;

            $env = [
                'APP_NAME'               => $shop->shop_name,
                'APP_ENV'                => 'local ',
                'APP_KEY'                => '',
                'APP_DEBUG'              => 'false',
                'APP_URL'                => $shop->url(),
                'APP_DOMAIN'             => $domain,
                'DB_CONNECTION'          => 'mysql',
                'DB_HOST'                => '127.0.0.1',
                'DB_PORT'                => '3306',
                'DB_DATABASE'            => $dbDatabase,
                'DB_USERNAME'            => $dbUsername,
                'DB_PASSWORD'            => md5($shop->id + time()),
            ];

            return json_encode($env);

        }
    }
}
