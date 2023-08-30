<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;

class ShopOrderController extends Controller
{
    public function index(Request $request) {
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

        $orders = $query->where('is_delete', 0)->orderBy('id','DESC')->paginate(20);
        return view('user.shop.order.index', compact('orders'));
    }
}
