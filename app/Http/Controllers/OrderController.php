<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use App\Models\Settings;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\UserWallet;
use App\Models\Transaction;
use App\Models\Shop;
use App\Models\Brand;
use App\User;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();
        if (!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->orWhere('order_number', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('full_name', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('email', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('address1', 'LIKE', "%{$request->keyword}%");
            });
        }
        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        $orders = $query->where('is_delete', 0)->orderBy('id', 'DESC')->paginate(20);
        return view('backend.order.index')->with('orders', $orders);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'full_name' => 'string|required',
                'province_id' => 'required',
                'district_id' => 'required',
                'ward_id' => 'required',
                'address1' => 'string|required',
                'coupon' => 'nullable|numeric',
                'phone' => 'numeric|required',
                'post_code' => 'string|nullable',
                'email' => 'string|required'
            ]);

            $user = User::find($request->user()->id);
            $setting = Settings::first();

            $carts = Cart::selectRaw('carts.*')
                ->where('user_id', $user->id)->where('order_number', null)->get();

            if (empty($carts)) {
                request()->session()->flash('error', 'Không có sản phẩm nào trong giỏ hàng!');
                return back();
            }

            $order = new Order();
            $orderData = $request->except(['district_id', 'ward_id', 'brand_id']);
            $orderData['order_number'] = 1000000000000 + $user->id + time();
            $orderData['user_id'] = $user->id;
            $orderData['shipping_id'] = $request->shipping;
            $orderData['sub_total'] = Helper::totalShopCartPrice($request->brand_id);
            $orderData['quantity'] = Helper::cartCount();
            $orderData['status'] = "new";
            $orderData['shop_id'] = $setting->shop_id;

            $shippingFee = 0;
            $coupon = session('coupon') ? session('coupon')['value'] : 0;

            $orderData['coupon'] = $coupon;
            $orderData['total_amount'] = $orderData['sub_total'] + $shippingFee - $coupon;

            if ($request->payment_method == 'cod') {
                $orderData['payment_status'] = 'unpaid';
            }

            if ($request->payment_method == 'bank') {
                $orderData['payment_status'] = 'unpaid';
            }

            $order->fill($orderData);
            $brand = Brand::find($request->brand_id);

            $data = [
                'shop_id' =>  $brand->ghsv_id == 0 ? 460 : $brand->ghsv_id,
                'product' => $carts[0]->product->title,
                'weight' => 1,
                'price' => $orderData['sub_total'],
                'to_name' => $request->input('full_name'),
                'to_phone' => $request->input('phone'),
                'to_province' => $request->input('province_id'),
                'to_district' => $request->input('district_id'),
                'to_ward' => $request->input('ward_id'),
                'to_address' => $request->input('address1')
            ];

           
                $status = $order->save();
                if ($status) {
                    // Import to MetaDSV
                    if ($orderData['shop_id'] != '') {
                        if (Order::on('dbcenter')->create($orderData)) {
                            foreach ($carts as $cart) {
                                $bonus = $cart->product->bonus();
                                // Insert cart to MetaDSV
                                $dataCart = $cart->toArray();
                                unset($dataCart['id']);
                                unset($dataCart['product']);
                                $dataCart['order_number'] = $order->order_number;
                                $dataCart['bonus'] = $bonus;
                                Cart::on('dbcenter')->create($dataCart);
                                // update cart
                                $cart->order_number = $order->order_number;
                                $cart->bonus = $bonus;
                                $cart->save();
                            }
                        }
                    } 
                    else {
                        Cart::where('user_id', $user->id)->where('order_number', null)->update(['order_number' => $order->order_number]);
                    }

                    // Send notification
                    $users = User::where('role', 'admin')->first();
                    $details = [
                        'title' => 'Đơn hàng mới',
                        'actionURL' => '/admin/order/' . $order->order_number,
                        'fas' => 'fas fa-cubes'
                    ];
                    Notification::send($users, new StatusNotification($details));
                    session()->forget('cart');
                    session()->forget('coupon');
                    request()->session()->flash('success', 'Tạo đơn hàng thành công, đơn hàng sẽ được vận chuyển đến bạn trong thời gian sớm nhất.');
                    return redirect()->route('home');
                } 
                else {
                    request()->session()->flash('error', 'Tạo đơn hàng thất bại, xin hãy thử lại, hoặc liên hệ với chúng tôi để đặt hàng nhanh chóng.');
                    return redirect()->back();
                }
            
        } 
        catch (\Throwable $th) {
            return $th;
        }
    }

    public function show($orderNumber)
    {
        $order = Order::where(['order_number' => $orderNumber])->first();
        return view('backend.order.show')->with('order', $order);
    }

    public function edit($orderNumber)
    {
        $order = Order::where(['order_number' => $orderNumber])->first();
        return view('backend.order.edit')->with('order', $order);
    }

    public function update(Request $request, $orderNumber)
    {
        $order = Order::where(['order_number' => $orderNumber])->first();
        $this->validate($request, [
            'status' => 'required|in:new,process,delivered,cancel'
        ]);
        $data = $request->all();

        if ($request->status == 'delivered') {
            foreach ($order->cart as $cart) {
                $product = $cart->product;
                $product->stock -= $cart->quantity;
                $product->save();
            }
        }
        $status = $order->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Cập nhật đơn hàng thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('order.index');
    }

    public function destroy($orderNumber)
    {
        $order = Order::where(['order_number' => $orderNumber])->first();
        if ($order) {
            $status = $order->update(['is_delete' => 1]);
            if ($status) {
                request()->session()->flash('success', 'Xóa đơn hàng thành công');
            } else {
                request()->session()->flash('error', 'Không thể xóa đơn hàng');
            }
            return redirect()->route('order.index');
        } else {
            request()->session()->flash('error', 'Không tìm thấy đơn hàng');
            return redirect()->back();
        }
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request)
    {
        $order = Order::where('user_id', auth()->user()->id)->where('order_number', $request->order_number)->first();
        if ($order) {
            if ($order->status == "new") {
                request()->session()->flash('message', 'Đơn hàng <b>' . $request->order_number . '</b> của bạn <b>ĐÃ ĐƯỢC TẠO</b>, vui lòng chờ đợi.');
                return redirect()->back();
            } elseif ($order->status == "process") {
                request()->session()->flash('message', 'Đơn hàng <b>' . $request->order_number . '</b> của bạn <b>ĐANG ĐƯỢC XỬ LÝ</b>, vui lòng đợi thêm.');
                return redirect()->back();
            } elseif ($order->status == "delivered") {
                request()->session()->flash('message', 'Đơn hàng <b>' . $request->order_number . '</b> của bạn đã được <b>GIAO HÀNG THÀNH CÔNG</b>.');
                return redirect()->back();
            } else {
                request()->session()->flash('message', 'Đơn hàng <b>' . $request->order_number . '</b> của bạn <b>ĐÃ BỊ HỦY</b>');
                return redirect()->back();
            }
        } else {
            request()->session()->flash('message', 'Mã đơn đặt hàng không hợp lệ, vui lòng thử lại');
            return back();
        }
    }

    public function pdf(Request $request)
    {
        $order = Order::getAllOrder($request->orderNumber);
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
        $pdf = PDF::loadview('backend.order.pdf', compact('order'));
        return $pdf->download($file_name);
    }

    public function incomeChart(Request $request)
    {
        $year = Carbon::now()->year;
        $items = Order::with(['cart_info'])
            ->whereYear('created_at', $year)
            ->where('status', 'delivered')
            ->get()
            ->groupBy(function ($d) {
                return Carbon::parse($d->created_at)->format('m');
            });

        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                $m = intval($month);
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = date('n', mktime(0, 0, 0, $i, 1));
            $data[$month] = (!empty($result[$i])) ? number_format(($result[$i])) : 0;
        }

        return $data;
    }

    public function bonusApproved(Request $request)
    {
        $order = Order::where('order_number', $request->orderNumber)->first();
        if (!empty($order) && $order->bonus_status != '1') {
            $shop = Shop::where('id', $order->shop_id)->first();
            if (!empty($shop)) {
                $userWallet = UserWallet::where(['wallet_id' => 1, 'user_id' => $shop->user_id])->first();
                if (empty($userWallet)) {
                    $userWallet = UserWallet::create([
                        'user_id' => $shop->user_id,
                        'wallet_id' => 1,
                        'status' => 1,
                    ]);
                }
                $userWallet->updateWalletReferrers($order->bonus(), $order->orrder_number);
                $order->bonus_status = 1;
                $order->save();
                return response()->json(['success' => true]);
            }
        }
    }
}
