<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class BrandController extends Controller
{
    public function index()
    {
        $brand=Brand::orderBy('id','DESC')->paginate(20);
        return view('backend.brand.index')->with('brands',$brand);
    }

    public function create()
    {
        return view('backend.brand.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required',
        ]);
        // Chuẩn bị dữ liệu để gửi đi
        $currentDateTime = Carbon::now();
        $timestamp = $currentDateTime->timestamp;
        $data = [
            'name' => $request->input('title') . $timestamp,
            'phone' => $request->input('phone'),
            'province' => $request->input('province'),
            'district' => $request->input('district'),
            'ward' => $request->input('ward'),
            'address' => $request->input('address')
        ];

        // Chuyển đổi dữ liệu thành JSON
        $jsonData = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ghsv.vn/v1/shop/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Token: ' . env('TOKEN_GHSV'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response, true);
        if(!$responseData['success'])
        {
            return "API tạo shop thất bại. Lỗi: " . $responseData['msg'] ;
        }
        else {
            $data=$request->all();
            $data['ghsv_id'] = $responseData['shop']['id'];
            $slug=Str::slug($request->title);
            $count=Brand::where('slug',$slug)->count();
            if($count>0){
                $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
            }
            $data['slug']=$slug;
            $status=Brand::create($data);
            if($status){
                request()->session()->flash('success','Thêm thương hiệu thành công');
            }
            else{
                request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
            }
            return redirect()->route('brand.index');
        }


        // $this->validate($request,[
        //     'title'=>'string|required',
        // ]);
        // $data=$request->all();
        // $slug=Str::slug($request->title);
        // $count=Brand::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // // return $data;
        // $status=Brand::create($data);
        // if($status){
        //     request()->session()->flash('success','Thêm thương hiệu thành công');
        // }
        // else{
        //     request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        // }
        // return redirect()->route('brand.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $brand=Brand::find($id);
        if(!$brand){
            request()->session()->flash('error','Brand not found');
        }
        return view('backend.brand.edit')->with('brand',$brand);
    }

    public function update(Request $request, $id)
    {
        $brand=Brand::find($id);
        $this->validate($request,[
            'title'=>'string|required',
        ]);
        // $data=$request->all();

        // $status=$brand->fill($data)->save();
        // if($status){
        //     request()->session()->flash('success','Cập nhật thương hiệu thành công');
        // }
        // else{
        //     request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        // }
        // return redirect()->route('brand.index');
        
        $currentDateTime = Carbon::now();
        $timestamp = $currentDateTime->timestamp;
        $data = [
            'name' => $request->input('title') . $timestamp,
            'phone' => $request->input('phone'),
            'province' => $request->input('province'),
            'district' => $request->input('district'),
            'ward' => $request->input('ward'),
            'address' => $request->input('address')
        ];

        // Chuyển đổi dữ liệu thành JSON
        $jsonData = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ghsv.vn/v1/shop/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Token: ' . env('TOKEN_GHSV'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response, true);
        if(!$responseData['success'])
        {
            return "API tạo shop thất bại. Lỗi: " . $responseData['msg'] ;
        }
        else {
            $data=$request->all();
            $data['ghsv_id'] = $responseData['shop']['id'];
            $slug=Str::slug($request->title);
            // $count=Brand::where('slug',$slug)->count();
            // if($count>0){
            //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
            // }
            $data['slug']=$slug;
            // $status=Brand::create($data);
            $status=$brand->fill($data)->save();
            if($status){
                request()->session()->flash('success','Thêm thương hiệu thành công');
            }
            else{
                request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
            }
            return redirect()->route('brand.index');
        }
    }

    public function destroy($id)
    {
        $brand=Brand::find($id);
        if($brand){
            $status=$brand->delete();
            if($status){
                request()->session()->flash('success','Xóa thương hiệu thành công');
            }
            else{
                request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
            }
            return redirect()->route('brand.index');
        }
        else{
            request()->session()->flash('error','Brand not found');
            return redirect()->back();
        }
    }
}
