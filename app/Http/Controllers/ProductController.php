<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
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

        $data = $request->except(['_token', 'files', 'size_name', 'size_price','size_price_sale']);
        $slug = Str::slug($request->title);

        $count = Product::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        
        $status=Product::create($data);

        // THANH DEV 
         $get_id_pro =$status->id;
         // dd($get_id_pro);
            $size_name = $request->size_name;
            $size_price = $request->size_price;
            $size_price_sale =$request->size_price_sale;
            
               if (!empty($size_name)) {
                    for ($j = 0; $j < count($size_name); $j++) {
                        if (!empty($size_name[$j])) {
                            $data_size = array(
                                'size_name' => $size_name[$j],
                                'size_price' => $size_price[$j],
                                'size_price_sale' => $size_price_sale[$j],
                                'product_id' => $get_id_pro
                            );
                            DB::table('tbl_size')->insert($data_size);
                        }
                    }
                }

        // THANH DEV 

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
        $edit_data_size = DB::table('products')
        ->join('tbl_size','tbl_size.product_id','=','products.id')
        ->where('products.id',$id)->get();
        $categories = Category::where('is_parent',1)->get();
        $tokenUnits = Wallet::where('is_token', 1)->get();
        $items = Product::where('id',$id)->get();
        // return $items;
        return view('backend.product.edit', compact('product', 'brands', 'categories', 'items', 'tokenUnits', 'units','edit_data_size'));
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
        $product = Product::findOrFail($id);
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'link_titkok' => 'string|nullable',
            'link_youtube' => 'string|nullable',
            'link_facebook' => 'string|nullable',
            'photo' => 'string|required',
            'stock' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'brand_id' => 'nullable|exists:brands,id',
            'unit_id' => 'nullable|exists:units,id',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'import_price' => 'nullable|numeric',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);

        $data = $request->except(['_token', 'files', 'size_name', 'size_price', 'size_price_sale', 'id_size']);
        $data['is_featured'] = $request->input('is_featured', 0);

        $status = $product->fill($data)->save();

        $size_name = $request->size_name;
        $size_price = $request->size_price;
        $size_price_sale = $request->size_price_sale;
        $id_size = $request->id_size;

        for ($j = 0; $j < count($size_name); $j++) {
            if (!empty($size_name[$j])) {
                $data_size = [
                    'size_name' => $size_name[$j],
                    'size_price' => $size_price[$j],
                    'size_price_sale' => $size_price_sale[$j],
                    'product_id' => $id
                ];

                if (!empty($id_size[$j])) {
                    // Nếu có id_size thì cập nhật
                    DB::table('tbl_size')->where('id', $id_size[$j])->update($data_size);
                } else {
                    // Ngược lại, thêm mới
                    DB::table('tbl_size')->insert($data_size);
                }
            }
        }

        if ($status) {
            request()->session()->flash('success', 'Cập nhật sản phẩm thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại');
        }

        return redirect()->route('product.index');
    }

     public function delete_muti_size(Request $request){
        $id_size = $request->id;
        $product_id = $request->product_id;
        DB::table('tbl_size')->where('id', $id_size)->where('product_id', $product_id)->delete();

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
