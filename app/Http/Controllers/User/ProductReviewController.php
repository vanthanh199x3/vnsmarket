<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;

class ProductReviewController extends Controller
{
    public function productReviewIndex(){
        $reviews=ProductReview::getAllUserReview();
        return view('user.review.index')->with('reviews',$reviews);
    }

    public function productReviewEdit($id)
    {
        $review=ProductReview::find($id);
        return view('user.review.edit')->with('review',$review);
    }

    public function productReviewUpdate(Request $request, $id)
    {
        $review=ProductReview::find($id);
        if($review){
            $data=$request->all();
            $status=$review->fill($data)->update();
            if($status){
                request()->session()->flash('success','Cập nhật đánh giá thành công');
            }
            else{
                request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
            }
        }
        else{
            request()->session()->flash('error','Không tìm thấy đánh giá');
        }

        return redirect()->route('user.productreview.index');
    }

    public function productReviewDelete($id)
    {
        $review=ProductReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('success','Xóa đánh giá thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('user.productreview.index');
    }
}
