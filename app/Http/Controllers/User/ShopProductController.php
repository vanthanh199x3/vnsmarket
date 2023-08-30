<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Wallet;
use App\Models\Category;

class ShopProductController extends Controller
{
    public function index(Request $request) {
        $query = Product::query();
        if (!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->orWhere('title', 'LIKE', "%{$request->keyword}%");
            });
        }

        $products = $query->orderBy('id','DESC')->paginate(20);
        return view('user.shop.product.index', compact('products'));
    }

    public function detail($id) {
        $brands = Brand::on('dbcenter')->get();
        $units = Unit::on('dbcenter')->get();
        $product = Product::on('dbcenter')->findOrFail($id);
        $categories = Category::on('dbcenter')->where('is_parent',1)->get();
        $tokenUnits = Wallet::on('dbcenter')->where('is_token', 1)->get();
        $items = Product::on('dbcenter')->where('id',$id)->get();
        return view('user.shop.product.detail', compact('product', 'brands', 'categories', 'items', 'tokenUnits', 'units'));
    }

    public function import(Request $request) {
        $query = Product::on('dbcenter')->where('status', 'active')->orderBy('id', 'desc');
        
        if ($request->ajax()) {
    		if (!empty($request->keyword)) {
                $query->where('title', 'LIKE', "%$request->keyword%"); 
            }
            if (!empty($request->cat_id)) {
                $query->where('cat_id', $request->cat_id);
            }
            if (!empty($request->brand_id)) {
                $query->where('brand_id', $request->brand_id);
            }
            $products = $query->paginate(12);
            $view = view('user.shop.product.includes.import_product', compact('products'))->render();
            return response()->json(['html' => $view]);
        }

        $products = $query->paginate(12);
        $brands = Brand::on('dbcenter')->get();
        $categories = Category::on('dbcenter')->where(['is_parent' => 1])->get();
        return view('user.shop.product.import', compact('categories', 'brands', 'products'));
    }

    public function importSubmit(Request $request) {
        $ids = array_filter($request->ids ?? []);
        $result['success'] = false;
        if (!empty($ids)) {
            $products = Product::on('dbcenter')->where('status', 'active')->whereIn('id', $ids)->get();
            if (!empty($products)) {
                foreach($products as $product) {
                    $this->updateCategory($product->cat_id);
                    $this->updateBrand($product->brand_id);
                    $this->updateUnit($product->unit_id);
                    $data = $product->toArray();
                    $data['is_import'] = 1;
                    Product::updateOrCreate(['id' => $data['id']], $data);
                }
            }
            $result['success'] = true;
            $result['message'] = 'Nhập sản phẩm thành công';
        } else {
            $result['message'] = 'Đã xảy ra lỗi, xin hãy thử lại!';
        }

        return response()->json($result);
    }

    public function updateCategory($id) {
        $category = Category::on('dbcenter')->find($id);
        if (!empty($category)) {
            $check = Category::find($id);
            if (empty($check)) {
                $data = $category->toArray();
                unset($data['created_at']);
                unset($data['updated_at']);
                \DB::table('categories')->insert($data);
            }
            if ($category->parent_id != '') {
                $this->updateCategory($category->parent_id);
            }
        }
    }

    public function updateBrand($id) {
        $brand = Brand::on('dbcenter')->find($id);
        if (!empty($brand)) {
            $check = Brand::find($id);
            if (empty($check)) {
                $data = $brand->toArray();
                unset($data['created_at']);
                unset($data['updated_at']);
                \DB::table('brands')->insert($data);
            }
        }
    }

    public function updateUnit($id) {
        $unit = Unit::on('dbcenter')->find($id);
        if (!empty($unit)) {
            $check = Unit::find($id);
            if (empty($check)) {
                $data = $unit->toArray();
                unset($data['created_at']);
                unset($data['updated_at']);
                \DB::table('units')->insert($data);
            }
        }
    }

    public function importUpdate($ids = array()) {
        if (empty($ids)) {
            $ids = Product::where('is_import', 1)->pluck('id')->toArray();
        }
        $query = Product::on('dbcenter')->whereIn('id', $ids);
        $query->chunk(500, function ($products) {
            foreach ($products as $product) {
                $data = $product->toArray();
                unset($data['created_at']);
                $data['is_import'] = 1;
                $data['updated_at'] = date('Y-m-d H:i:s');
                Product::updateOrCreate(['id' => $data['id']], $data);
            }
        });

        return response()->json(['success' => true, 'message' => 'Cập nhật tất cả sản phẩm thành công']);
    }
    
    public function importDelete(Request $request) {
        // $product = Product::findOrFail($id);
        
        // $status = $product->delete();
        
        // if($status){
        //     request()->session()->flash('success','Xóa sản phẩm thành công');
        // }
        // else{
        //     request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
        // }
        // return redirect()->route('product.index');
    }
}
