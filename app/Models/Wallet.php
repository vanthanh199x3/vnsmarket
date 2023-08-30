<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Wallet extends Model
{
    protected $connection = 'dbcenter';
    protected $guarded = [];

    public function policy($walletID = NULL) {
        
        $walletID = $walletID ? $walletID : $this->id;
        
        $policy = [];

        if ($walletID == 1) {

            $policy = [
                'filia' => [
                    'F1' => 0,
                    'F2' => 0,
                ],
                'direct' => 50,
            ];

        }

        if ($walletID == 2) {

            $policy = [
                'filia' => [
                    'F1' => 35,
                    'F2' => 20,
                    'F3' => 10,
                    'F4' => 8,
                    'F5' => 7,
                    'F6' => 3,
                    'F7' => 3,
                    'F8' => 3,
                    'F9' => 3,
                    'F10' => 3,
                    'F11' => 1.5,
                    'F12' => 1.5,
                    'F13' => 1.5,
                    'F14' => 1.5,
                    'F15' => 1.5,
                    'F16' => 1.5,
                    'F17' => 1.5,
                    'F18' => 1.5,
                    'F19' => 1.5,
                    'F20' => 1.5,
                ],
                'direct' => NULL,
                'condition' => [
                    'filia' => [
                        'F1' => 1,
                        'F2' => 2,
                        'F3' => 3,
                        'F4' => 4,
                        'F5' => 5,
                        'F6' => 6,
                        'F7' => 7,
                        'F8' => 8,
                        'F9' => 9,
                        'F10' => 10,
                        'F11' => 11,
                        'F12' => 12,
                        'F13' => 13,
                        'F14' => 14,
                        'F15' => 15,
                        'F16' => 16,
                        'F17' => 17,
                        'F18' => 18,
                        'F19' => 19,
                        'F20' => 20,
                    ]
                ]
            ];

        }

        return $policy;
    }

    public static function transfer($data) {

        $result = 
        DB::transaction(function () use($data) {
        
            $acceptTypes = [1,2,3,4];
            $acceptWallets = [1,2];

            if (empty($data['type']) || 
                empty($data['wallet_id']) || 
                empty($data['from']) || 
                empty($data['to']) || 
                empty($data['money']) 
            ) {
                return [
                    'status' => 'error',
                    'message' => 'ERROR: Missing parameters!'
                ];
            }

            if (!in_array($data['type'], $acceptTypes)) {
                return [
                    'status' => 'error',
                    'message' => 'ERROR: Not found transfer type!'
                ];
            }

            if (!in_array($data['wallet_id'], $acceptWallets)) {
                return ['error' => 'ERROR: Not found wallet!'];
            }

            $from = \App\User::where('id', $data['from'])->first();;
            $to = \App\User::where('id', $data['to'])->first();
            if (empty($from)) {
                return [
                    'status' => 'error',
                    'message' => 'Giao dịch thất bại, người gửi không tồn tại!'
                ];
            }
            if (empty($to)) {
                return [
                    'status' => 'error',
                    'message' => 'Giao dịch thất bại, người nhận không tồn tại!'
                ];
            }

            $fromWallet = UserWallet::where(['wallet_id' => $data['wallet_id'],'user_id' => $data['from']])->first();
            $toWallet = UserWallet::where(['wallet_id' => $data['wallet_id'],'user_id' => $data['to']])->first();

            if (empty($fromWallet)) {
                $fromWallet = UserWallet::create([
                    'user_id' => $from->id,
                    'wallet_id' => $data['wallet_id'],
                    'status' => 1,
                ]);
            }

            if (empty($toWallet)) {
                $toWallet = UserWallet::create([
                    'user_id' => $to->id,
                    'wallet_id' => $data['wallet_id'],
                    'status' => 1,
                ]);
            }

            // Validate wallet money
            if (floatval($data['money']) > floatval($fromWallet->money)) {
                return [
                    'status' => 'error',
                    'message' => 'Số dư ví không đủ, vui lòng nạp thêm!'
                ];
            }

            // Initialization transaction
            $dataTransaction = [
                'transaction_time' => Carbon::now(),
                'transaction_id'   => $from->id.time(),
                'transaction_type' => $data['type'],
                'from'             => $from->id,
                'to'               => $to->id,
                'money'            => $data['money'],
                'fee'              => 0,
                'wallet_id'        => $data['wallet_id'],
                'content'          => $data['content'] ?? NULL,
                'status'           => $data['status'] ?? 1,
            ];

            if ($data['wallet_id'] == 1) {
                $transaction = Transaction::create($dataTransaction);
            } else {
                $transaction = TransactionToken::create($dataTransaction);
            }

            if ($transaction) {
                if ($dataTransaction['status'] == 1) {
                    
                    $fromWallet->old_balance = $fromWallet->money;
                    $fromWallet->money = floatval($fromWallet->money) - floatval($dataTransaction['money']);
                    $fromWallet->save();

                    $toWallet->old_balance = $toWallet->money;
                    $toWallet->money = floatval($toWallet->money) + floatval($dataTransaction['money']);
                    $toWallet->save();

                    return [
                        'status' => 'success',
                        'message' => "Thực hiện giao dịch thành công!",
                    ];

                } else {
                    return [
                        'status' => 'success',
                        'message' => "Yêu cầu thành công, giao dịch của bạn đang được phê duyệt!"
                    ];
                }
                
            } else {
                return [
                    'status' => 'error',
                    'message' => "Thực hiện giao dịch thất bại, xin hãy thử lại!"
                ];
            }

        });

        return $result;
    }
}
