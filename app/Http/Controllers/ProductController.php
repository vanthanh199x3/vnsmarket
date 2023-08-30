<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Wallet;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();
        if (!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->orWhere('title', 'LIKE', "%{$request->keyword}%");
            });
        }

        $products = $query->orderBy('id','DESC')->paginate(20);

        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::get();
        $categories = Category::where('is_parent', 1)->get();
        $units = Unit::get();
        $tokenUnits = Wallet::where('is_token', 1)->get();
        // return $category;
        return view('backend.product.create', compact('categories', 'brands', 'units', 'tokenUnits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'link_titkok'=>'string|nullable',
            'link_youtube'=>'string|nullable',
            'link_facebook'=>'string|nullable',
            'photo'=>'string|required',
            // 'size'=>'nullable',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'unit_id'=>'nullable|exists:units,id',
            // 'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'import_price'=>'required|numeric',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);

        $data = $request->except(['_token', 'files']);
        $slug = Str::slug($request->title);
        $count = Product::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);

        // $size=$request->input('size');
        // if($size){
        //     $data['size']=implode(',',$size);
        // }
        // else{
        //     $data['size']='';
        // }
        // return $size;
        // return $data;
        $status=Product::create($data);
        if($status){
            request()->session()->flash('success','Thêm sản phẩm thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
        }
        return redirect()->route('product.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands = Brand::get();
        $units = Unit::get();
        $product = Product::findOrFail($id);
        $categories = Category::where('is_parent',1)->get();
        $tokenUnits = Wallet::where('is_token', 1)->get();
        $items = Product::where('id',$id)->get();
        // return $items;
        return view('backend.product.edit', compact('product', 'brands', 'categories', 'items', 'tokenUnits', 'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'link_titkok'=>'string|nullable',
            'link_youtube'=>'string|nullable',
            'link_facebook'=>'string|nullable',
            'photo'=>'string|required',
            // 'size'=>'nullable',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            // 'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'brand_id'=>'nullable|exists:brands,id',
            'unit_id'=>'nullable|exists:units,id',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'import_price'=>'nullable|numeric',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);

        $data = $request->except(['_token', 'files']);
        
        $data['is_featured']=$request->input('is_featured',0);
        // $size=$request->input('size');
        // if($size){
        //     $data['size']=implode(',',$size);
        // }
        // else{
        //     $data['size']='';
        // }
        // return $data;
        $status=$product->fill($data)->save();
        if($status){
            request()->session()->flash('success','Cập nhật sản phẩm thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();
        
        if($status){
            request()->session()->flash('success','Xóa sản phẩm thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
        }
        return redirect()->route('product.index');
    }
}
