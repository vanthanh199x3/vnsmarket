<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
class WishlistController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function wishlist(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('error','Không tìm thấy sản phẩm');
            return back();
        }        
        $product = Product::where('slug', $request->slug)->first();
        // return $product;
        if (empty($product)) {
            request()->session()->flash('error','Không tìm thấy sản phẩm');
            return back();
        }

        $already_wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id',null)->where('product_id', $product->id)->first();
        // return $already_wishlist;
        if($already_wishlist) {
            request()->session()->flash('error','Bạn đã thêm sản phẩm này rồi');
            return back();
        }else{
            
            $wishlist = new Wishlist;
            $wishlist->user_id = auth()->user()->id;
            $wishlist->product_id = $product->id;
            $wishlist->price = ($product->price-($product->price*$product->discount)/100);
            $wishlist->quantity = 1;
            $wishlist->amount=$wishlist->price*$wishlist->quantity;
            if ($wishlist->product->stock < $wishlist->quantity || $wishlist->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $wishlist->save();
        }
        request()->session()->flash('success','Đã thêm vào danh sách yêu thích');
        return back();       
    }  
    
    public function wishlistDelete(Request $request){
        $wishlist = Wishlist::find($request->id);
        if ($wishlist) {
            $wishlist->delete();
            request()->session()->flash('success','Đã xóa khỏi danh sách yêu thích');
            return back();  
        }
        request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
        return back();       
    }     
}
