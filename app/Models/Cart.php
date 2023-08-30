<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];
    
    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }
    // public static function getAllProductFromCart(){
    //     return Cart::with('product')->where('user_id',auth()->user()->id)->get();
    // }
    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_number');
    }
}