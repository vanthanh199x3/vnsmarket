<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\User;
use App\Models\Category;

class CategoryController extends Controller
{

    public function getAllCategory() { 
        $cats = Category::limit(16)->get();
        return json_decode($cats);
    }
    
    public function getProduct($id) { 
        $product = Product::find($id);

        if (!$product) {
            // Nếu không tìm thấy sản phẩm, trả về thông báo "Sản phẩm không tồn tại"
            return response()->json([
                'success' => false,
                'msg' => 'Sản phẩm không tồn tại'
            ]);
        }
    
        // Tất cả các điều kiện đã được thoả mãn, trả về sản phẩm và thành công
        return response()->json([
            'success' => true,
            'msg' => '',
            'data' => $product
        ]);
    }
    

}

