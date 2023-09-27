<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Newsletter;
use DB;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

use App\Rules\MatchOldPassword;
use Illuminate\Validation\Rule;

use App\User;
use App\Models\Order;
use App\Models\Settings;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Page;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\Wallet;
use App\Models\UserWallet;
use App\Models\NewsletterEmail;
use App\Models\PointTransfer;

class FrontendController extends Controller
{

    public function __construct()
    {
        $setting = Settings::first();

        SEOMeta::setDescription($setting->short_des);
        SEOMeta::addKeyword($setting->short_des);

        OpenGraph::setDescription($setting->short_des);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage($setting->shortcut, ['height' => 140, 'width' => 140 ]);
    }
   
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }

    public function home(){

        SEOMeta::setTitle(__('web.home'));
        OpenGraph::setTitle(__('web.home'));

        $featured=Product::where('status','active')->where('is_featured',1)->orderBy('price','DESC')->limit(2)->get();
        $posts=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $horizontal_banners=Banner::where(['status' => 'active', 'type' => 1])->limit(3)->orderBy('id','DESC')->get();
        $vertical_banners=Banner::where(['status' => 'active', 'type' => 2])->limit(3)->orderBy('id','DESC')->get();
        $products=Product::where('status','active')->orderBy('created_at','DESC')->paginate(24);
        $category=Category::where('status','active')->where('is_parent',1)->orderBy('title','ASC')->get();
 
        return view('frontend.index')
                ->with('featured',$featured)
                ->with('posts',$posts)
                ->with('horizontal_banners',$horizontal_banners)
                ->with('vertical_banners',$vertical_banners)
                ->with('product_lists',$products)
                ->with('category_lists',$category);
    }   

    public function aboutUs(){
        SEOMeta::setTitle( __('web.about'));
        OpenGraph::setTitle( __('web.about'));
        return view('frontend.pages.about-us');
    }

    public function contact(){
        SEOMeta::setTitle( __('web.contact'));
        OpenGraph::setTitle( __('web.contact'));
        return view('frontend.pages.contact');
    }

    public function page($slug) {
        $page = Page::where(['slug' => $slug])->first();
        if (!empty($page)) {
            SEOMeta::setTitle($page->title);
            SEOMeta::setDescription(strip_tags($page->title));
            SEOMeta::addKeyword($page->title);
    
            OpenGraph::setTitle($page->title);
            OpenGraph::setDescription(strip_tags($page->title));
            OpenGraph::setUrl(url()->current());
        }
        return view('frontend.pages.page', compact('page'));
    }

    public function productDetail($slug){
        $product_detail = Product::getProductBySlug($slug);
        if (!empty($product_detail)) {
            SEOMeta::setTitle($product_detail->title);
            SEOMeta::setDescription(strip_tags($product_detail->summary));
            SEOMeta::addKeyword($product_detail->title);
            
            OpenGraph::setTitle($product_detail->title);
            OpenGraph::setDescription(strip_tags($product_detail->summary));
            OpenGraph::setUrl(url()->current());
            OpenGraph::addImage($product_detail->photo, ['height' => 315, 'width' => 600 ]);
        } 

          $get_size_row = DB::table('products')
        ->join('tbl_size','tbl_size.product_id','=','products.id')
        ->where('products.id',$product_detail->id)->first(); 

         $get_size = DB::table('products')
        ->join('tbl_size','tbl_size.product_id','=','products.id')
        ->where('products.id',$product_detail->id)->get(); 


        return view('frontend.pages.product_detail')->with('product_detail',$product_detail)->with('get_size',$get_size)->with('get_size_row',$get_size_row);
    }

   public function ajax_load_price_size(Request $request)
{
    $id_size = $request->get_id_size; 
    $id_pro = $request->id_pro; 

    $get_size_row = Product::join('tbl_size', 'tbl_size.product_id', '=', 'products.id')
        ->where('products.id', $id_pro)
        ->where('tbl_size.id', $id_size)
        ->first();

    $price_size = view('frontend.pages.ajax.ajax_price_size', compact('get_size_row'))->render();

    // Trả về JSON response
    return response()->json(['price_size' => $price_size]);
}

 

    public function productGrids(){
        SEOMeta::setTitle( __('web.product'));
        OpenGraph::setTitle( __('web.product'));

        $products = Product::query();
        
        $categorySlug = '';
        if(!empty($_GET['category'])){
            $category = Category::where('slug', $_GET['category'])->first();
            if (!empty($category)) {
                $categorySlug = $_GET['category'];
                $ids = Category::childrenIds($category);
                $products->whereIn('cat_id', $ids);
            }
        }
        

        // if(!empty($_GET['brand'])){
        //     $slugs=explode(',',$_GET['brand']);
        //     $brand_ids=Brand::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
        //     return $brand_ids;
        //     $products->whereIn('brand_id',$brand_ids);
        // }
        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy']=='price_low_to_high'){
                $products->orderBy('price','ASC');
            }
            if($_GET['sortBy']=='price_high_to_low'){
                $products->orderBy('price','DESC');
            }
            if($_GET['sortBy']=='hot'){
                $products->orderByRaw("`condition` LIKE '%{$_GET['sortBy']}%' DESC");
            }
            if($_GET['sortBy']=='new'){
                $products->orderByRaw("`condition` LIKE '%{$_GET['sortBy']}%' DESC");
            }
        } else {
            $products->orderBy('created_at', 'DESC');
        }

        if(!empty($_GET['price'])){
            $price = explode('-',$_GET['price']);
            $products->whereBetween('price', $price);
        }
        
        // Sort by number
        if(!empty($_GET['show'])){
            $products = $products->where('status','active')->paginate($_GET['show']);
        }
        else{
            $products = $products->where('status','active')->paginate(16);
        }

        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
      
        return view('frontend.pages.product-grids', compact('products', 'recent_products', 'categorySlug'));
    }
    // public function productLists(){
    //     $products=Product::query();
        
    //     if(!empty($_GET['category'])){
    //         $slug=explode(',',$_GET['category']);
    //         // dd($slug);
    //         $cat_ids=Category::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
    //         // dd($cat_ids);
    //         $products->whereIn('cat_id',$cat_ids)->paginate;
    //         // return $products;
    //     }
    //     if(!empty($_GET['brand'])){
    //         $slugs=explode(',',$_GET['brand']);
    //         $brand_ids=Brand::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
    //         return $brand_ids;
    //         $products->whereIn('brand_id',$brand_ids);
    //     }
    //     if(!empty($_GET['sortBy'])){
    //         if($_GET['sortBy']=='title'){
    //             $products=$products->where('status','active')->orderBy('title','ASC');
    //         }
    //         if($_GET['sortBy']=='price'){
    //             $products=$products->orderBy('price','ASC');
    //         }
    //     }

    //     if(!empty($_GET['price'])){
    //         $price=explode('-',$_GET['price']);
    //         // return $price;
    //         // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
    //         // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));
            
    //         $products->whereBetween('price',$price);
    //     }

    //     $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
    //     // Sort by number
    //     if(!empty($_GET['show'])){
    //         $products=$products->where('status','active')->paginate($_GET['show']);
    //     }
    //     else{
    //         $products=$products->where('status','active')->paginate(6);
    //     }
    //     // Sort by name , price, category

      
    //     return view('frontend.pages.product-lists')->with('products',$products)->with('recent_products',$recent_products);
    // }
    public function productFilter(Request $request){

        SEOMeta::setTitle( __('web.product'));
        OpenGraph::setTitle( __('web.product'));

        $data= $request->all();
        // return $data;
        $showURL="";
        if(!empty($data['show'])){
            $showURL .='&show='.$data['show'];
        }

        $sortByURL='';
        if(!empty($data['sortBy'])){
            $sortByURL .='&sortBy='.$data['sortBy'];
        }

        $catURL="";
        if(!empty($data['category'])){
            $catURL .='&category='.$data['category'];
            // foreach($data['category'] as $category){
            //     if(empty($catURL)){
            //         $catURL .='&category='.$category;
            //     }
            //     else{
            //         $catURL .=','.$category;
            //     }
            // }
        }

        $brandURL="";
        if(!empty($data['brand'])){
            $brandURL .='&brand='.$data['brand'];
            // foreach($data['brand'] as $brand){
            //     if(empty($brandURL)){
            //         $brandURL .='&brand='.$brand;
            //     }
            //     else{
            //         $brandURL .=','.$brand;
            //     }
            // }
        }

        $priceRangeURL="";
        if(!empty($data['price_range'])){
            $priceRangeURL .='&price='.$data['price_range'];
        }
        return redirect()->route('product-grids',$catURL.$brandURL.$priceRangeURL.$showURL.$sortByURL);
    }

    public function productSearch(Request $request){

        SEOMeta::setTitle($request->search);
        OpenGraph::setTitle($request->search);

        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $products=Product::where('status','active')
                    ->where(function ($query) use ($request) {
                        $query->where('title','like','%'.$request->search.'%')
                        ->orwhere('slug','like','%'.$request->search.'%')
                        ->orwhere('description','like','%'.$request->search.'%')
                        ->orwhere('summary','like','%'.$request->search.'%');
                        })
                        // ->orwhere('price','like','%'.$request->search.'%')
                    ->orderBy('id','DESC')
                    ->paginate('12');
        return view('frontend.pages.product-grids')->with('products',$products)->with('recent_products',$recent_products);
    }

    public function productBrand(Request $request){

        $brand = Brand::where('slug', $request->slug)->first();
        if (!empty($brand)) {
            SEOMeta::setTitle($brand->title);
            OpenGraph::setTitle($brand->title);
        }
        
        $brandSlug = $request->slug;
        $breadcrumb = $brand->title;
        $products = Brand::getProductByBrand($brandSlug);
        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get(); 
        return view('frontend.pages.product-grids', compact('products', 'recent_products', 'brandSlug', 'breadcrumb'));

    }
    public function productCat(Request $request){

        $category = Category::where('slug', $request->slug)->first();
        if (!empty($category)) {
            SEOMeta::setTitle($category->title);
            OpenGraph::setTitle($category->title);
        }

        $products = Category::getProductByCat($request->slug);
        $recent_products = Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $categorySlug = $request->slug;
        $breadcrumb = $category->title;
        return view('frontend.pages.product-grids', compact('products', 'recent_products', 'categorySlug', 'breadcrumb'));

    }
    // public function productSubCat(Request $request){
    //     $products=Category::getProductBySubCat($request->sub_slug);
    //     // return $products;
    //     $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();

    //     if(request()->is('e-shop.loc/product-grids')){
    //         return view('frontend.pages.product-grids')->with('products',$products->sub_products)->with('recent_products',$recent_products);
    //     }
    //     else{
    //         return view('frontend.pages.product-lists')->with('products',$products->sub_products)->with('recent_products',$recent_products);
    //     }

    // }

    public function blog(){

        SEOMeta::setTitle( __('web.post'));
        OpenGraph::setTitle( __('web.post'));

        $post = Post::query();
        
        if(!empty($_GET['category'])){
            $slug=explode(',',$_GET['category']);
            // dd($slug);
            $cat_ids=PostCategory::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id',$cat_ids);
            // return $post;
        }
        if(!empty($_GET['tag'])){
            $slug=explode(',',$_GET['tag']);
            // dd($slug);
            $tag_ids=PostTag::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id',$tag_ids);
            // return $post;
        }

        if(!empty($_GET['show'])){
            $post=$post->where('status','active')->orderBy('id','DESC')->paginate($_GET['show']);
        }
        else{
            $post=$post->where('status','active')->orderBy('id','DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogDetail($slug){
        $post = Post::getPostBySlug($slug);

        if (!empty($post)) {
            SEOMeta::setTitle($post->title);
            SEOMeta::setDescription(strip_tags($post->summary));
            SEOMeta::addKeyword($post->title);
            
            OpenGraph::setTitle($post->title);
            OpenGraph::setDescription(strip_tags($post->summary));
            OpenGraph::setUrl(url()->current());
            OpenGraph::addImage($post->photo, ['height' => 315, 'width' => 600 ]);
        }

        $rcnt_post = Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog-detail')->with('post',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogSearch(Request $request){
        // return $request->all();
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $posts=Post::orwhere('title','like','%'.$request->search.'%')
            ->orwhere('quote','like','%'.$request->search.'%')
            ->orwhere('summary','like','%'.$request->search.'%')
            ->orwhere('description','like','%'.$request->search.'%')
            ->orwhere('slug','like','%'.$request->search.'%')
            ->orderBy('id','DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts',$posts)->with('recent_posts', $rcnt_post);
    }

    public function blogFilter(Request $request){
        $data = $request->all();
        $catURL = "";
        if(!empty($data['category'])){
            foreach($data['category'] as $category){
                if(empty($catURL)){
                    $catURL .='&category='.$category;
                }
                else{
                    $catURL .=','.$category;
                }
            }
        }

        $tagURL="";
        if(!empty($data['tag'])){
            foreach($data['tag'] as $tag){
                if(empty($tagURL)){
                    $tagURL .='&tag='.$tag;
                }
                else{
                    $tagURL .=','.$tag;
                }
            }
        }

        return redirect()->route('blog',$catURL.$tagURL);
    }

    public function blogByCategory(Request $request){
        $post=PostCategory::getBlogByCategory($request->slug);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post->post)->with('recent_posts',$rcnt_post);
    }

    public function blogByTag(Request $request){
        // dd($request->slug);
        $post=Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    // Login
    public function login(){
        if(Auth::check()){
            return redirect()->route('home');
        }
        SEOMeta::setTitle( __('web.login'));
        OpenGraph::setTitle( __('web.login'));
        session()->put('redirectLogin', url()->previous());
        return view('frontend.pages.login');
    }

    public function loginSubmit(Request $request){

        if(Auth::check()){
            return redirect()->route('home');
        }

        $data = $request->all();
        $user = User::where(['email' => $data['email'], 'status'=>'inactive'])->first();
        if($user)
        {
            request()->session()->flash('error','Tài khoản của bạn đã bị vô hiệu hóa!');
            return redirect()->back();
        }
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'status'=>'active'])){
            Session::put('user',$data['email']);
            request()->session()->flash('success','Đăng nhập thành công');

            // create default wallet
            $wallets = Wallet::all();
            foreach($wallets as $wallet) {
                UserWallet::updateOrCreate([
                    'user_id' => Auth::id(),
                    'wallet_id' => $wallet->id, 
                ],[
                    'user_id' => Auth::id(),
                    'wallet_id' => $wallet->id,
                    'status' => 1,
                ]);
            }

            if (session()->has('redirectLogin')) {
                return redirect()->to(session('redirectLogin'));
            } else {
                return redirect()->route('home');
            }
        }
        else{
            request()->session()->flash('error','Email hoặc mật khẩu không chính xác, xin hãy hãy thử lại');
            return redirect()->back();
        }
    }

    public function logout(){
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success','Đã đăng xuất thành công');
        return back();
    }

    public function register(Request $reques){

        if(Auth::check()){
            return redirect()->route('home');
        }

        SEOMeta::setTitle( __('web.register'));
        OpenGraph::setTitle( __('web.register'));

        $ref = $reques->r ?? '';
        $affiliateEmail = '';
        if ($ref != '') {
            $affiliateId = \Helper::getReferrer($ref);
            $affiliateUser = User::find($affiliateId);
            $affiliateEmail = $affiliateUser->phone;
        }

        return view('frontend.pages.register', compact('affiliateEmail'));
    }

    public function registerSubmit(Request $request){

        if(Auth::check()){
            return redirect()->route('home');
        }

        $this->validate($request, [
            'name'=>'string|required|min:3|max:50',
            'email'=>'email|required|unique:users',
            'phone'=>'numeric|nullable|unique:users',
            'password'=>'required|min:6|confirmed',
            'referrer' => 'nullable|exists:users,phone',
            // 'referrer' => 'nullable|email|exists:users,email',
        ]);

        $data = $request->all();

        // $startRef = 66;
        // if ($data['referrer'] != '') {
        //     $referrer = User::where('email', $data['referrer'])->orwhere('phone', $data['referrer'])->first();
        //     if ($referrer->id > $startRef) {
        //         $data['referrer'] = $referrer->id;
        //     } else {
        //         $data['referrer'] = $startRef;
        //     }
        // } else {
        //     $data['referrer'] = $startRef;
        // }
        
        if ($data['referrer'] != '') {
            $referrer = User::where('email', $data['referrer'])->orwhere('phone', $data['referrer'])->first();
            $data['referrer'] = $referrer->id;
        }

        $data['password'] = Hash::make($request->password);
        $data['role'] = 'user';
        
        Session::put('user', $data['email']);

        $check = User::create($data);
        if($check){

            // create default wallet
            $wallets = Wallet::all();
            foreach($wallets as $wallet) {
                UserWallet::create([
                    'user_id' => $check->id,
                    'wallet_id' => $wallet->id,
                    'status' => 1,
                ]);
            }

            request()->session()->flash('success','Tạo tài khoản thành công');
            return redirect()->route('login.form');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại');
            return back();
        }
    }
    // public function create(array $data){
    //     return User::create([
    //         'name'=>$data['name'],
    //         'email'=>$data['email'],
    //         'phone'=>$data['phone'],
    //         'password'=>Hash::make($data['password']),
    //         'status'=>'active',
    //         'referrer'=>$data['referrer'],
    //     ]);
    // }

    // Reset password
    // public function showResetForm(){
    //     if(Auth::check()){
    //         return redirect()->route('home');
    //     }
    //     return view('auth.passwords.old-reset');
    // }

    // public function resetPassword(Request $request){
    //     return view('auth.passwords.reset');
    // }

    public function passwordRequest(){
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('auth.passwords.forgot');
    }

    public function passwordEmail() {
        $credentials = request()->validate(['email' => 'required|email']);
        Password::sendResetLink($credentials);
        request()->session()->flash('message','Chúng tôi đã gửi một liên kết khôi phục mật khẩu đến email của bạn, vui lòng kiểm tra và làm theo hướng dẫn, bao gồm cả hộp thư rác.');
        return back();
    }

    public function passwordReset(Request $request){
        return view('auth.passwords.reset');
    }

    public function passwordUpdate() {
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            request()->session()->flash('error', 'Mã xác thực email không trùng khớp hoặc đã hết hạn, vui lòng thực hiện lại thao tác quên mật khẩu.');
            return back();
        }

        request()->session()->flash('success','Thay đổi mật khẩu mới thành công.');
        return redirect()->route('login.form');
    }

    public function subscribe(Request $request){
        // $result['status'] = false;
        $check = NewsletterEmail::where('email', $request->email)->first();
        if ($check) {
            // $result['message'] = "Bạn đã đăng ký nhận tin qua email {$request->email} rồi.";
            request()->session()->flash('error',"Bạn đã đăng ký nhận tin qua email {$request->email} rồi.");
        } else {
            NewsletterEmail::create(['email' => $request->email]);
            request()->session()->flash('success','Đăng ký thành công, hãy kiểm tra email thường xuyên để nhận được được các ưu đãi sớm nhất.');
            //$result['status'] = true;
            //$result['message'] = "Đăng ký thành công, hãy kiểm tra email thường xuyên để nhận được được các ưu đãi sớm nhất.";
        }

        return back();
        // return response()->json($result);

        // Old use Newsletter
        // if(!Newsletter::isSubscribed($request->email)){
        //     Newsletter::subscribePending($request->email);
        //     if(Newsletter::lastActionSucceeded()){
        //         request()->session()->flash('success','Đăng ký thành công!');
        //         return redirect()->route('home');
        //     }
        //     else{
        //         Newsletter::getLastError();
        //         return back()->with('error','Đã xảy ra lỗi, xin hãy thử lại');
        //     }
        // }
        // else{
        //     request()->session()->flash('error','Bạn đã đăng ký trước đó rồi');
        //     return back();
        // }
    }

    // User Profile
    public function password(Request $request) {

        if ($request->isMethod('post')) {
            $request->validate([
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => ['required'],
                'new_confirm_password' => ['same:new_password'],
            ]);
            
            $user = Auth()->user();
            $user->fill(['password'=> Hash::make($request->new_password)])->save();

            return redirect()->back()->with('message','Thay đổi mật khẩu thành công');
        }

        return view('frontend.pages.user.password');
    }

    public function profile(Request $request){

        $profile = Auth()->user();

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'name'=>'string|required|min:3|max:50',
                'phone'=> ['numeric', 'nullable', Rule::unique('users')->ignore($profile->id)],
                'address' => 'nullable',
            ]);

            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ];
            
            if($request->hasFile('id_card_front')) {
                $file = $request->file('id_card_front');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = md5(time().$request->email.'id_card_front').'.'.$fileExtension;
                $file->storeAs('public/identifier/'.$profile->id, $fileName);
                $data['id_card_front'] = 'identifier/'.$profile->id.'/'.$fileName;
            } else {
                $data['id_card_front'] = null;
            }

            if($request->hasFile('id_card_back')) {
                $file = $request->file('id_card_back');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = md5(time().$request->email.'id_card_back').'.'.$fileExtension;
                $path = $file->storeAs('public/identifier/'.$profile->id, $fileName);
                $data['id_card_back'] = 'identifier/'.$profile->id.'/'.$fileName;
            } else {
                $data['id_card_back'] = null;
            }

            if($request->hasFile('portrait')) {
                $file = $request->file('portrait');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = md5(time().$request->email.'portrait').'.'.$fileExtension;
                $path = $file->storeAs('public/identifier/'.$profile->id, $fileName);
                $data['portrait'] = 'identifier/'.$profile->id.'/'.$fileName;
            } else {
                $data['portrait'] = null;
            }

            $status = $profile->fill($data)->save();
            if ($status) {
                return redirect()->back()->with('message','Cập nhật thông tin tài khoản thành công');
            }   
        }

        return view('frontend.pages.user.profile', compact('profile'));
    }

    public function order() {
        
        $orders = Order::where([
            'user_id' => auth()->user()->id,
        ])->orderBy('id','DESC')->paginate(10);

        return view('frontend.pages.user.order', compact('orders'));
    }

     public function points() {
        // Lấy danh sách người dùng 
        $users = User::where('id', '!=', 1)->orderBy('id','ASC')->get();
        $points = Auth()->user();
         return view('frontend.pages.user.points')->with('points', $points)->with('users', $users);
    }

    public function transferPoints(Request $request)
{
    // Xác minh xem người dùng có đủ điểm không
    $sender = Auth::user();
    $receiver = User::find($request->input('receiver_id'));
    $amount = $request->input('amount');

    if ($sender->points < $amount) {
        return redirect()->back()->with('success', 'Số điểm không đủ để chuyển.');
    }

    // Tạo một bản ghi giao dịch mới
    PointTransfer::create([
        'sender_id' => $sender->id,
        'receiver_id' => $receiver->id,
        'amount' => $amount,
    ]);

    // Cập nhật số điểm cho người gửi và người nhận
    $sender->decrement('points', $amount);
    $receiver->increment('points', $amount);
    return redirect()->back()->with('success', 'Chuyển điểm thành công.');

}

    public function token() {
        $user = Auth::user();
        $userWallets = UserWallet::where('user_id', $user->id);
        return view('frontend.pages.user.token', compact('userWallets'));
    }
    // End User Profile
}
