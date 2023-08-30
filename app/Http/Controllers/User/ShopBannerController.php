<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;

class ShopBannerController extends Controller
{
    public function index()
    {
        $banner=Banner::orderBy('id','DESC')->paginate(10);
        return view('user.shop.banner.index')->with('banners',$banner);
    }

    public function create()
    {
        return view('user.shop.banner.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Banner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $status=Banner::create($data);
        if($status){
            request()->session()->flash('success','Thêm banner thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('shop.banner.index');
    }

    public function edit($id)
    {
        $banner=Banner::findOrFail($id);
        return view('user.shop.banner.edit')->with('banner',$banner);
    }

    public function update(Request $request, $id)
    {
        $banner=Banner::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data = $request->all();
        $status = $banner->fill($data)->save();
        if($status){
            request()->session()->flash('success','Cập nhật banner thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('shop.banner.index');
    }

    public function destroy($id)
    {
        $banner=Banner::findOrFail($id);
        $status=$banner->delete();
        if($status){
            request()->session()->flash('success','Xóa banner thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('shop.banner.index');
    }
}
