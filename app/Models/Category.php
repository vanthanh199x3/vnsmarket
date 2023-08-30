<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{ 
    protected $fillable=['title','slug','summary','photo','status','is_parent','parent_id', 'level', 'added_by'];

    public function parent_info(){
        return $this->hasOne('App\Models\Category','id','parent_id');
    }
    public static function getAllCategory(){
        return  Category::orderBy('id','DESC')->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id){
        return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }
    public static function getChildByParentID($id){
        return Category::where('parent_id',$id)->orderBy('id','ASC')->pluck('title','id');
    }

    public function child_cat(){
        return $this->hasMany('App\Models\Category','parent_id','id')->where('status','active');
    }
     
    public static function getAllParentWithChild(){
        return Category::with('child_cat')->where('is_parent',1)->where('status','active')->orderBy('title','ASC')->get();
    }
    // public function products(){
    //     return $this->hasMany('App\Models\Product','cat_id','id')->where('status','active');
    // }
    // public function sub_products(){
    //     return $this->hasMany('App\Models\Product','child_cat_id','id')->where('status','active');
    // }

    public static function childrenIds($lv1) {
        $ids = [];
        if (!empty($lv1)) {
            array_push($ids, $lv1->id);
            if($lv1->child_cat->count()) {
                foreach($lv1->child_cat as $lv2) {
                    array_push($ids, $lv2->id);
                    if ($lv2->child_cat->count()) {
                        foreach($lv2->child_cat as $lv3) {
                            array_push($ids, $lv3->id);
                        }
                    }
                }
            }
        }

        return $ids;
    }

    public static function getProductByCat($slug){
        $category = Category::where('slug', $slug)->first();
        $subCategoryIds = self::childrenIds($category);
        $products = Product::whereIn('cat_id', $subCategoryIds)->where('status', 'active')->paginate(12);
        return $products; 
    }

    // public static function getProductByCat($slug){
    //     // dd($slug);
    //     return Category::with('products')->where('slug',$slug)->first();
    //     // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    // }
    // public static function getProductBySubCat($slug){
    //     // return $slug;
    //     return Category::with('sub_products')->where('slug',$slug)->first();
    // }
    public static function countActiveCategory(){
        $data=Category::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
