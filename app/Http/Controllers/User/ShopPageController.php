<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;

class ShopPageController extends Controller
{
    public function index() {
        $pages = Page::orderBy('id', 'desc')->paginate(20);
        return view('user.shop.page.index', compact('pages'));
    }

    public function create()
    {
        return view('user.shop.page.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'string|required',
            'status' => 'required',
            'type' => 'required',
        ]);

        $data = $request->except('files');
        $slug = Str::slug($request->title);
        $count = Page::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.time();
        }
        $data['slug']=$slug;

        $status = Page::create($data);

        if($status){
            request()->session()->flash('success','Thêm trang mới thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('shop.page.index');
    }

    public function edit($id) {
        $page = Page::find($id);
        return view('user.shop.page.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);
        $this->validate($request,[
            'title' => 'string|required',
            'status' => 'required',
            'type' => 'required',
        ]);

        $data = $request->except('files');
        $status = $page->fill($data)->save();
        if($status){
            request()->session()->flash('success','Cập nhật trang thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('shop.page.index');
    }

    public function destroy($id) {
        $page = Page::findOrFail($id);
        $status = $page->delete();
        if($status){
            request()->session()->flash('success','Xóa trang thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('shop.page.index');
    }
}
