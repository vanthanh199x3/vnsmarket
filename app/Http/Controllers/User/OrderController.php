<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function orderIndex(){

        $orders = Order::where([
            'is_delete' => 0,
            'user_id' => auth()->user()->id,
        ])->orderBy('id','DESC')->paginate(10);
        
        return view('user.order.index')->with('orders',$orders);
    }

    public function userOrderDelete($order_number)
    {
        $order = Order::where(['order_number' => $orderNumber, 'user_id' => auth()->user()->id])->first();

        if($order){

           if($order->status=="process" || $order->status=='delivered' || $order->status=='cancel'){
                return redirect()->back()->with('error','Không thể xóa đơn hàng');
           }
           else{
                $status = $order->update(['is_delete' => 1]);
                if($status){
                    request()->session()->flash('success','Xóa đơn hàng thành công');
                }
                else{
                    request()->session()->flash('error','Không thể xóa đơn hàng');
                }
                return redirect()->route('user.order.index');
           }
        }
        else{
            request()->session()->flash('error', 'Không tìm thấy đơn hàng');
            return redirect()->back();
        }
    }

    public function userOrderCancel($orderNumber)
    {
        $order = Order::where(['order_number' => $orderNumber, 'user_id' => auth()->user()->id])->first();
        if($order){

           if($order->status=="process" || $order->status=='delivered'){
                return redirect()->back()->with('error','Không thể hủy đơn hàng');
           }
           else{
                $status = $order->update(['status' => 'cancel']);
                if($status){
                    Order::on('dbcenter')->where('order_number', $orderNumber)->update(['status' => 'cancel']);
                    request()->session()->flash('success','Hủy đơn hàng thành công');
                }
                else{
                    request()->session()->flash('error','Không thể hủy đơn hàng');
                }
                return redirect()->route('user.order.index');
           }
        }
        else{
            request()->session()->flash('error', 'Không tìm thấy đơn hàng');
            return redirect()->back();
        }
    }

    public function orderShow($order_number)
    {
        $order = Order::where(['order_number' => $order_number, 'user_id' => auth()->user()->id])->first();
        return view('user.order.show')->with('order', $order);
    }
}
