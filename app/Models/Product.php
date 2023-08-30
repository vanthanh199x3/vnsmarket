<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
class Product extends Model
{
    protected $guarded = [];

    protected $appends = ['stock'];

    public function getStockAttribute()
    {
        $stock = $this->attributes['stock'];
        if ($this->is_import) {
            $product = \App\Models\Product::on('dbcenter')->find($this->id);
            $stock = $product->stock ?? 0;
        }
        return $this->attributes['stock'] = $stock;
    }

    public function cat_info(){
        return $this->hasOne('App\Models\Category','id','cat_id');
    }
    public function sub_cat_info(){
        return $this->hasOne('App\Models\Category','id','child_cat_id');
    }
    // public static function getAllProduct(){
    //     return Product::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
    // }
    public function rel_prods(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->orderBy('id','DESC')->limit(8);
    }
    public function getReview(){
        return $this->hasMany('App\Models\ProductReview','product_id','id')->with('user_info')->where('status','active')->orderBy('id','DESC');
    }
    public static function getProductBySlug($slug){
        return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();
    }
    public static function countActiveProduct(){
        $data=Product::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public function carts(){
        return $this->hasMany(Cart::class)->whereNotNull('order_number');
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    }

    public function brand(){
        return $this->hasOne(Brand::class,'id','brand_id');
    }

    public function token_unit() {     
        $unit = '';
        if ($this->price_token > 0) {
            switch($this->price_token_unit){
                case 2:
                    $unit = '(DSV Coin)';
                    break;
                default:
                    $unit = '';
            }
        }
        return $unit;
    }

    public function bonus()
    {
        $wallet = new Wallet();
        $policy = $wallet->policy(1);
        $profit = $this->price - $this->import_price;
        $bonus = $profit > 0 ? ($profit*$policy['direct'])/100 : 0;
        return $bonus;
    }

}
