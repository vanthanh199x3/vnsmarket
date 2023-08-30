<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostComment;

class PostCommentController extends Controller
{
    public function userComment()
    {
        $comments=PostComment::getAllUserComments();
        return view('user.comment.index')->with('comments',$comments);
    }
    
    public function userCommentDelete($id){
        $comment=PostComment::find($id);
        if($comment){
            $status=$comment->delete();
            if($status){
                request()->session()->flash('success','Xóa bình luận thành công');
            }
            else{
                request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
            }
            return back();
        }
        else{
            request()->session()->flash('error','Không tìm thấy bình luận');
            return redirect()->back();
        }
    }

    public function userCommentEdit($id)
    {
        $comments=PostComment::find($id);
        if($comments){
            return view('user.comment.edit')->with('comment',$comments);
        }
        else{
            request()->session()->flash('error','Không tìm thấy bình luận');
            return redirect()->back();
        }
    }

    public function userCommentUpdate(Request $request, $id)
    {
        $comment=PostComment::find($id);
        if($comment){
            $data=$request->all();
            // return $data;
            $status=$comment->fill($data)->update();
            if($status){
                request()->session()->flash('success','Cập nhật bình luận thành công');
            }
            else{
                request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
            }
            return redirect()->route('user.post-comment.index');
        }
        else{
            request()->session()->flash('error','Không tìm thấy bình luận');
            return redirect()->back();
        }

    }
}
