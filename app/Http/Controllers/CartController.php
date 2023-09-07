<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Helper;

use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Bank;
use App\Models\Coupon;
use App\Models\UserWallet;

class CartController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function addToCart(Request $request){
        if (empty($request->slug)) {
            request()->session()->flash('error','Sản phẩm không tồn tại');
            return back();
        }
        $product = Product::where('slug', $request->slug)->first();
        // return $product;
        if (empty($product)) {
            request()->session()->flash('error','Sản phẩm không tồn tại');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_number',null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price+ $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Số lượng sản phẩm không đủ.');
            $already_cart->save();

        }else{

            $cart = new Cart;
            $cart->brand_id = $product->brand_id;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price-($product->price*$product->discount)/100);
            $cart->quantity = 1;
            $cart->amount=$cart->price*$cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Số lượng sản phẩm không đủ.');
            $cart->save();
            $wishlist=Wishlist::where('user_id',auth()->user()->id)->where(['cart_id' => null, 'product_id' => $product->id])->update(['cart_id'=>$cart->id]);
        }
        request()->session()->flash('success','Đã thêm vào giỏ hàng');

        $couponCode = session()->get('coupon')['code'] ?? "";
        if($couponCode != "")
        {
            $coupon=Coupon::where('code',$couponCode)->first();
            $total_price=Cart::where('user_id',auth()->user()->id)->where('order_number',null)->sum('amount');
            // dd($total_price);
            session()->put('coupon',[
                'id'=>$coupon->id,
                'code'=>$coupon->code,
                'value'=>$coupon->discount($total_price)
            ]);
        }
        return back();
    }

    public function singleAddToCart(Request $request){
        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);

        $product = Product::where('slug', $request->slug)->first();
        if($product->stock <$request->quant[1]){
            return back()->with('error','Số lượng sản phẩm không đủ');
        }
        if ( ($request->quant[1] < 1) || empty($product) ) {
            request()->session()->flash('error','Sản phẩm không tồn tại');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_number',null)->where('product_id', $product->id)->first();

        // return $already_cart;

        if($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
            $already_cart->amount = ($product->price * $request->quant[1])+ $already_cart->amount;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Số lượng sản phẩm không đủ');

            $already_cart->save();

        }else{

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->brand_id = $product->brand_id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price-($product->price*$product->discount)/100);
            $cart->quantity = $request->quant[1];
            $cart->amount=($product->price * $request->quant[1]);
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            // return $cart;
            $cart->save();
        }
        request()->session()->flash('success','Đã thêm vào giỏ hàng');
        $couponCode = session()->get('coupon')['code'] ?? "";
        if($couponCode != "")
        {
            $coupon=Coupon::where('code',$couponCode)->first();
            $total_price=Cart::where('user_id',auth()->user()->id)->where('order_number',null)->sum('amount');
            // dd($total_price);
            session()->put('coupon',[
                'id'=>$coupon->id,
                'code'=>$coupon->code,
                'value'=>$coupon->discount($total_price)
            ]);
        }
        return back();
    }

    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success','Đã xóa khỏi giỏ hàng');
            $couponCode = session()->get('coupon')['code'] ?? "";
            if($couponCode != "")
            {
                $coupon=Coupon::where('code',$couponCode)->first();
                $total_price=Cart::where('user_id',auth()->user()->id)->where('order_number',null)->sum('amount');
                // dd($total_price);
                session()->put('coupon',[
                    'id'=>$coupon->id,
                    'code'=>$coupon->code,
                    'value'=>$coupon->discount($total_price)
                ]);
            }
            return back();
        }
        request()->session()->flash('error','Đã xay ra lỗi, xin hãy thử lại');
        return back();
    }

    public function cartUpdate(Request $request){
        // dd($request->all());
        if($request->quant){
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k=>$quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if($quant > 0 && $cart) {
                    // return $quant;

                    if($cart->product->stock < $quant){
                        request()->session()->flash('error','Số lượng sản phẩm không đủ');
                        return back();
                    }
                    $cart->quantity = ($cart->product->stock > $quant) ? $quant  : $cart->product->stock;
                    // return $cart;

                    if ($cart->product->stock <=0) continue;
                    $after_price=($cart->product->price-($cart->product->price*$cart->product->discount)/100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Cập nhật giỏ hàng thành công';
                    $couponCode = session()->get('coupon')['code'] ?? "";
                    if($couponCode != "")
                    {
                        $coupon=Coupon::where('code',$couponCode)->first();
                        $total_price=Cart::where('user_id',auth()->user()->id)->where('order_number',null)->sum('amount');
                        // dd($total_price);
                        session()->put('coupon',[
                            'id'=>$coupon->id,
                            'code'=>$coupon->code,
                            'value'=>$coupon->discount($total_price)
                        ]);
                    }
                }else{
                    $error[] = 'Giỏ hàng không khả dụng';
                }
            }
            return back()->with($error)->with('success', $success);
        }else{
            return back()->with('Giỏ hàng không khả dụng');
        }
    }

    // public function addToCart(Request $request){
    //     // return $request->all();
    //     if(Auth::check()){
    //         $qty=$request->quantity;
    //         $this->product=$this->product->find($request->pro_id);
    //         if($this->product->stock < $qty){
    //             return response(['status'=>false,'msg'=>'Out of stock','data'=>null]);
    //         }
    //         if(!$this->product){
    //             return response(['status'=>false,'msg'=>'Product not found','data'=>null]);
    //         }
    //         // $session_id=session('cart')['session_id'];
    //         // if(empty($session_id)){
    //         //     $session_id=Str::random(30);
    //         //     // dd($session_id);
    //         //     session()->put('session_id',$session_id);
    //         // }
    //         $current_item=array(
    //             'user_id'=>auth()->user()->id,
    //             'id'=>$this->product->id,
    //             // 'session_id'=>$session_id,
    //             'title'=>$this->product->title,
    //             'summary'=>$this->product->summary,
    //             'link'=>route('product-detail',$this->product->slug),
    //             'price'=>$this->product->price,
    //             'photo'=>$this->product->photo,
    //         );

    //         $price=$this->product->price;
    //         if($this->product->discount){
    //             $price=($price-($price*$this->product->discount)/100);
    //         }
    //         $current_item['price']=$price;

    //         $cart=session('cart') ? session('cart') : null;

    //         if($cart){
    //             // if anyone alreay order products
    //             $index=null;
    //             foreach($cart as $key=>$value){
    //                 if($value['id']==$this->product->id){
    //                     $index=$key;
    //                 break;
    //                 }
    //             }
    //             if($index!==null){
    //                 $cart[$index]['quantity']=$qty;
    //                 $cart[$index]['amount']=ceil($qty*$price);
    //                 if($cart[$index]['quantity']<=0){
    //                     unset($cart[$index]);
    //                 }
    //             }
    //             else{
    //                 $current_item['quantity']=$qty;
    //                 $current_item['amount']=ceil($qty*$price);
    //                 $cart[]=$current_item;
    //             }
    //         }
    //         else{
    //             $current_item['quantity']=$qty;
    //             $current_item['amount']=ceil($qty*$price);
    //             $cart[]=$current_item;
    //         }

    //         session()->put('cart',$cart);
    //         return response(['status'=>true,'msg'=>'Cart successfully updated','data'=>$cart]);
    //     }
    //     else{
    //         return response(['status'=>false,'msg'=>'You need to login first','data'=>null]);
    //     }
    // }

    // public function removeCart(Request $request){
    //     $index=$request->index;
    //     // return $index;
    //     $cart=session('cart');
    //     unset($cart[$index]);
    //     session()->put('cart',$cart);
    //     return redirect()->back()->with('success','Successfully remove item');
    // }

    public function checkout(Request $request){
        // $cart=session('cart');
        // $cart_index=\Str::random(10);
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'product_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }
        $provinces = \Kjmtrue\VietnamZone\Models\Province::get();
        $bank = Bank::masterShopBank();
        $userWallet = UserWallet::where([
            'user_id' => auth()->user()->id,
            'wallet_id' => 1
        ])->first();
        return view('frontend.pages.checkout', compact('bank', 'userWallet', 'provinces'));
    }



    public function checkoutBrand($brand_id){
        $bank = Bank::masterShopBank();
        $userWallet = UserWallet::where([
            'user_id' => auth()->user()->id,
            'wallet_id' => 1
        ])->first();
        return view('frontend.pages.checkout-brand', compact('bank', 'userWallet', 'brand_id'));
    }
}
