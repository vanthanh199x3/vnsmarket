<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_number','order_number');
    }
    public static function getAllOrder($orderNumber){
        return Order::with('cart_info')->where('order_number', $orderNumber)->first();
    }
    public static function countActiveOrder(){
        $data=Order::count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function cart(){
        return $this->hasMany(Cart::class, 'order_number','order_number');
    }
    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }
    public function province()
    {
        return $this->belongsTo('\Kjmtrue\VietnamZone\Models\Province', 'province_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'shop_id');
    }
    public function bonus() {
        $bonus = 0;
        $carts = Cart::where('order_number', $this->order_number)->get();
        foreach($carts as $cart) {
            $product = $cart->product;
            $bonus += $product->price - $product->import_price;
            // $bonus = $bonus + $cart->bonus;
        }
        return $bonus;
    }

}
