<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\Models\Wallet;
use App\Models\UserWallet;
use App\Models\Transaction;
use App\Models\TransactionToken;
use App\Models\Bank;

class WalletController extends Controller
{
    public function wallet($walletID) {
        $wallet = Wallet::find($walletID);
        $user = auth()->user();
    
        if ($wallet->is_token == '') {
            $histories = Transaction::whereRaw(" `from` = '{$user->id}' OR `to` = '{$user->id}'")->orderBy('id', 'desc')->paginate(20);
            $userWallet = UserWallet::where(['user_id' => $user->id, 'wallet_id' => $walletID])->first();
            return view('backend.wallet_money.index', compact('histories', 'userWallet'));
        } else {
            $wallets = Wallet::whereNotNull('is_token')->get();
            $histories = TransactionToken::whereRaw(" `from` = '{$user->id}' OR `to` = '{$user->id}' and wallet_id = '{$walletID}'")->orderBy('id', 'desc')->paginate(20);
            $userWallet = UserWallet::where(['user_id' => $user->id, 'wallet_id' => $walletID])->first();
            return view('backend.wallet_token.index', compact('wallets', 'histories', 'userWallet'));
        }
    }

    public function walletUpdate(Request $request, $walletID) {
        $this->validate($request,[
            'wallet_address' => 'required',
        ]);

        $userWallet = UserWallet::where(['user_id' => auth()->user()->id, 'wallet_id' => $walletID])->first();
        if (!empty($userWallet)) {
            $userWallet->wallet_address = $request->wallet_address;
            $userWallet->save();
            request()->session()->flash('success',"Cập nhật địa chỉ ví {$userWallet->wallet->name} thành công");
        }
        return redirect()->route('wallet', $walletID);
    }

    public function walletTransfer(Request $request, $walletID) {
        // Validate input
        $this->validate($request,[
            'transfer_to'=>'email|required',
            'money'=>'numeric|required',
        ]);

        $to = User::where('email', $request->transfer_to)->first();
        if (!empty($to)) {
            $data = [
                'from'      => auth()->user()->id,
                'to'        => $to->id,
                'type'      => 1,
                'money'     => $request->money,
                'wallet_id' => $walletID,
                'content'   => 'Chuyển tiền'
            ];
            $transfer = Wallet::transfer($data);
            if($request->ajax()){
                return response()->json($transfer);
            } else {
                request()->session()->flash($transfer['status'], $transfer['message']);
            }
        } else {
            if($request->ajax()){
                return response()->json(['status' => 'error', 'Giao dịch thất bại, người nhận không tồn tại']);
            } else {
                request()->session()->flash('error', 'Giao dịch thất bại, người nhận không tồn tại');
            }
        }

        return redirect()->back();
    }

    public function walletWithdraᴡ(Request $request, $walletID) {
        // Validate input
        $this->validate($request,[
            'money'=>'numeric|required',
        ]);

        $userBank = Bank::where('user_id', auth()->user()->id)->first();
        if (empty($userBank)) {
            request()->session()->flash('error', 'Bạn chưa cập nhật thông tin tài khoản ngân hàng.');
            return redirect()->back(); 
        }

        $toWalletUserId = 1;

        $data = [
            'from'      => auth()->user()->id,
            'to'        => $toWalletUserId,
            'type'      => 4,
            'money'     => $request->money,
            'wallet_id' => $walletID,
            'content'   => 'Rút tiền',
            'status'    => 0,
        ];
        $transfer = Wallet::transfer($data);
        request()->session()->flash($transfer['status'], $transfer['message']);
        return redirect()->back();
    }

    public function walletRequest(Request $request, $walletID) {

        if ($request->isMethod('post')) {

            DB::transaction(function () use($request, $walletID) {
                $transaction = Transaction::where(['transaction_id' => $request->transaction_id, 'status' => 0])->first();
                if (!empty($transaction)) {
                    $fromWallet = UserWallet::where(['wallet_id' => $walletID,'user_id' => $transaction->from])->first();
                    $fromWallet->money = floatval($fromWallet->money) - floatval($transaction->money);
                    $fromWallet->save();
                    
                    $toWallet = UserWallet::where(['wallet_id' => $walletID,'user_id' => $transaction->to])->first();
                    $toWallet->money = floatval($toWallet->money) + floatval($transaction->money);
                    $toWallet->save();

                    $transaction->status = 1;
                    $transaction->save();

                    request()->session()->flash('success', "Cập nhật giao dịch thành công, hãy đảm bảo rằng bạn đã chuyển khoản đến người yêu cầu!");
                }
            });

            return redirect()->back();
        }

        $query = Transaction::query();
        $query->where('transaction_type', 4);
        if (!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->orWhere('transaction_id', 'LIKE', "%{$request->keyword}%");
                $q->orWhere('from', 'LIKE', "%{$request->keyword}%");
                $q->orWhere('to', 'LIKE', "%{$request->keyword}%");
                $q->orWhere('money', 'LIKE', "%{$request->keyword}%");
                $q->orWhere('content', 'LIKE', "%{$request->keyword}%");
            });
        }

        if ($request->status != '') {
            $query->where('status', $request->status);
        }

        $requests = $query->orderBy('id', 'desc')->paginate(20);
        return view('backend.wallet_money.request', compact('requests'));
    }
    
    // Wallet manage
    // public function create(Request $request) {
    //     return view('backend.wallet.create');
    // }

    // public function store(Request $request)
    // {
    //     $this->validate($request,[
    //         'name'=>'string|required',
    //         'is_token'=>'required',
    //         'status'=>'required'
    //     ]);

    //     $data = $request->all();
    //     $status = Wallet::create($data);

    //     if($status){
    //         request()->session()->flash('success','Thêm ví mới thành công');
    //     }
    //     else{
    //         request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
    //     }
    //     return redirect()->route('wallet.index');
    // }

    // public function edit($id)
    // {
    //     $wallet = Wallet::find($id);
    //     if(!$wallet){
    //         request()->session()->flash('error','Không tìm thấy ví');
    //     }
    //     return view('backend.wallet.edit')->with('wallet', $wallet);
    // }

    // public function update(Request $request, $id)
    // {
    //     $wallet = Wallet::find($id);
    //     $this->validate($request, [
    //         'name'=>'string|required',
    //         'is_token'=>'required',
    //         'status'=>'required'
    //     ]);

    //     $data = $request->all();
    //     $status= $wallet->fill($data)->save();

    //     if($status){
    //         request()->session()->flash('success','Cập nhật ví thành công thành công');
    //     }
    //     else{
    //         request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
    //     }
    //     return redirect()->route('wallet.index');
    // }

    // public function destroy($id)
    // {
    //     $wallet = Wallet::find($id);
    //     if($wallet){
    //         $shipping->status = 0;
    //         if($status){
    //             request()->session()->flash('success','Xóa vận chuyển thành công');
    //         }
    //         else{
    //             request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
    //         }
    //         return redirect()->route('shipping.index');
    //     }
    //     else{
    //         request()->session()->flash('error','Shipping not found');
    //         return redirect()->back();
    //     }
    // }
}
