<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable=['title','ghsv_id','slug','status','phone','address','ward','district','province'];

    // public static function getProductByBrand($id){
    //     return Product::where('brand_id',$id)->paginate(10);
    // }
    public function products(){
        return $this->hasMany('App\Models\Product','brand_id','id')->where('status','active');
    }
    public static function getProductByBrand($slug){
        $brand = Brand::where('slug', $slug)->first();
        return Product::where(['brand_id' => $brand->id, 'status' => 'active'])->paginate(16);
    }
}
