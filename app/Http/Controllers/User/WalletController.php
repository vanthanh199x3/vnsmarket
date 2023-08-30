<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Models\Wallet;
use App\Models\UserWallet;
use App\Models\Transaction;
use App\Models\Bank;

class WalletController extends Controller
{
    public function wallet($walletID) {
        $wallet = Wallet::find($walletID);
        $user = auth()->user();
        
        if ($wallet->is_token == '') {
            $histories = Transaction::whereRaw(" `from` = '{$user->id}' OR `to` = '{$user->id}'")->orderBy('id', 'desc')->paginate(20);
            $userWallet = UserWallet::where(['user_id' => $user->id, 'wallet_id' => $walletID])->first();
            return view('user.wallet_money.index', compact('histories', 'userWallet'));
        } else {
            $userWallet = UserWallet::where(['user_id' => $user->id, 'wallet_id' => $walletID])->first();
            return view('user.wallet_token.index', compact('userWallet'));
        }
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
            request()->session()->flash($transfer['status'], $transfer['message']);
        } else {
            request()->session()->flash('error', 'Giao dịch thất bại, người nhận không tồn tại');
        }
       
        return redirect()->back();
    }

    public function walletWithdraᴡ(Request $request, $walletID) {
        // Validate input
        $this->validate($request,[
            'money'=>'numeric|required|min:100000',
        ]);

        $transaction = Transaction::where(['from' => auth()->user()->id, 'status' => 0, 'transaction_type' => 4])->first();
        if (!empty($transaction)) {
            request()->session()->flash('error', 'Bạn đã tạo một yêu cầu rút tiền trước đó nhưng chưa được duyệt.');
            return redirect()->back();
        }

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
        return redirect()->back();
    }

}
