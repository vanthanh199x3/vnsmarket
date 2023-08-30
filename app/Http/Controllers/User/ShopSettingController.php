<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Models\Settings;

class ShopSettingController extends Controller
{
    
    public function settingLayout(Request $request) {
        $data = Settings::first();

        if($request->isMethod('post')) {
            $this->validate($request,[
                'short_des'=>'required|string',
                'shortcut'=>'required',
                'logo'=>'required',
                'address'=>'required|string',
                'email'=>'required|email',
            ]);
    
            $data = $request->except('files');
            $settings = Settings::first();
            $status = $settings->fill($data)->save();
    
            if($status){
                request()->session()->flash('success','Cập nhật cài đặt thành công');
            }
            else{
                request()->session()->flash('error','Xin hãy thử lại');
            }
            return redirect()->back();
        }

        return view('user.shop.setting.layout', compact('data'));
    }

    public function settingIntroduce(Request $request) {
        $data = Settings::first();

        if($request->isMethod('post')) {
            $this->validate($request,[
                'photo'=>'required',
                'description'=>'required|string',
                'youtube_video'=>'url|nullable',
            ]);
    
            $data = $request->except('files');
            $settings = Settings::first();
            $status = $settings->fill($data)->save();
    
            if($status){
                request()->session()->flash('success','Cập nhật cài đặt thành công');
            }
            else{
                request()->session()->flash('error','Xin hãy thử lại');
            }
            return redirect()->back();
        }

        return view('user.shop.setting.introduce', compact('data'));
    }

    public function settingSocial(Request $request) {
        $data = Settings::first();

        if($request->isMethod('post')) {
            $this->validate($request,[
                'facebook'=>'url|nullable',
                'zalo'=>'url|nullable',
                'youtube'=>'url|nullable',
                'instagram'=>'url|nullable',
                'tiktok'=>'url|nullable',
            ]);
    
            $data = $request->except('files');
            $settings = Settings::first();
            $status = $settings->fill($data)->save();
    
            if($status){
                request()->session()->flash('success','Cập nhật cài đặt thành công');
            }
            else{
                request()->session()->flash('error','Xin hãy thử lại');
            }
            return redirect()->back();
        }

        return view('user.shop.setting.social', compact('data'));
    }

    public function settingPayment(Request $request) {

        if($request->isMethod('post')) {
            $this->validate($request,[
                'default_wallet'=>'required',
                'default_bank'=>'required',
            ]);
    
            $data = $request->except('files');
            $settings = Settings::first();
            $status = $settings->fill($data)->save();
    
            if($status){
                request()->session()->flash('success','Cập nhật cài đặt thành công');
            }
            else{
                request()->session()->flash('error','Xin hãy thử lại');
            }
            return redirect()->back();
        }

        $data = Settings::first();
        if (auth()->user()->role == 'admin') {
            $admins = User::where(['role' => 'admin', 'status' => 'active'])->get();
        }
        return view('user.shop.setting.payment', compact('data', 'admins'));
    }


    public function settings() {
        if (auth()->user()->role == 'shop') {
            $data = Settings::first();
            $admins = User::where(['id' => auth()->user()->id])->get();
            return view('user.shop.setting', compact('data', 'admins'));
        }
    }

    public function settingsUpdate(Request $request){
        $this->validate($request,[
            'short_des'=>'required|string',
            'description'=>'required|string',
            'photo'=>'required',
            'shortcut'=>'required',
            'logo'=>'required',
            'address'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required|string',
            'facebook'=>'url|nullable',
            'zalo'=>'url|nullable',
            'youtube'=>'url|nullable',
            'instagram'=>'url|nullable',
            'tiktok'=>'url|nullable',
            // 'default_wallet'=>'required',
            // 'default_bank'=>'required',
        ]);

        $data = $request->except('files');
        $settings = Settings::first();
        $status = $settings->fill($data)->save();

        if($status){
            request()->session()->flash('success','Cập nhật cài đặt thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
        }
        return redirect()->back();
    }
}
