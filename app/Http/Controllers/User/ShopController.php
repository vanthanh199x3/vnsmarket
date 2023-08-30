<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function shop() {
        $shop = Shop::where(['user_id' => auth()->user()->id])->first();
        if (!empty($shop)) {
            if($shop->status == 1) {
                
            } else {
                return view('user.shop.register', compact('shop'));
            }
        } else {
            return view('user.shop.register');
        }
    }

    public function register(Request $request) {
        $this->validate($request,[
            'shop_name'=>'required|max:200',
            'shop_domain'=>'unique:shops,shop_domain|required|regex:/^[a-z][a-z0-9]+$/i',
            'shop_phone'=>'unique:shops,shop_phone|required',
        ]);

        $data = $request->except('_token');
        $data['user_id'] = auth()->user()->id;
        $data['base_domain'] = request()->getHttpHost();

        $shop = Shop::create($data);

        if($shop){
            request()->session()->flash('success','Đăng ký mở cửa hàng thành công, chúng tôi đang xem xét thông tin của bạn');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('user.shop');
    }
}
