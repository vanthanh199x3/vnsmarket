<?php
namespace App\Http;

use Auth;
use QrCode;
use App\Models\Message;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Shipping;
use App\Models\Cart;

class Helper {

    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    }
    public static function getAllCategory(){
        $category=new Category();
        $menu=$category->getAllParentWithChild();
        return $menu;
    }

    public static function getHeaderCategory(){
        $category = new Category();

        $menu=$category->getAllParentWithChild();

        if($menu){
            ?>

            <li>
            <a href="javascript:void(0);"><?= __('web.category') ?><i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                <?php
                    foreach($menu as $cat_info){
                        if($cat_info->child_cat->count()>0){
                            ?>
                            <li><a href="<?php echo route('product-cat',$cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach($cat_info->child_cat as $sub_menu){
                                        ?>
                                        <li><a href="<?php echo route('product-sub-cat',[$cat_info->slug,$sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        else{
                            ?>
                                <li><a href="<?php echo route('product-cat',$cat_info->slug);?>"><?php echo $cat_info->title; ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
    }

    public static function productCategoryList($option='all'){
        if($option='all'){
            return Category::orderBy('id','DESC')->get();
        }
        return Category::has('products')->orderBy('id','DESC')->get();
    }

    public static function postTagList($option='all'){
        if($option='all'){
            return PostTag::orderBy('id','desc')->get();
        }
        return PostTag::has('posts')->orderBy('id','desc')->get();
    }

    public static function postCategoryList($option="all"){
        if($option='all'){
            return PostCategory::orderBy('id','DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id','DESC')->get();
    }
    // Cart Count
    public static function cartCount($user_id=''){

        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_number',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    // relationship cart with product
    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public static function getAllProductFromCart($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::with('product')->where('user_id',$user_id)->where('order_number',null)->orderBy('brand_id')->get();
        }
        else{
            return collect();
        }
    }

    public static function getCartShop($brand_id){
        if(Auth::check()){
            $user_id=auth()->user()->id;
            return Cart::with('product')
                ->where('user_id',$user_id)
                ->where('order_number',null)
                ->where('brand_id', $brand_id)
                ->get();
        }
        else{
            return collect();
        }
    }

    public static function getProductByBlog($user_id='') {
        if(Auth::check()){
            if($user_id=="")
                $user_id=auth()->user()->id;
            $cartItems = Cart::with('product')->where('user_id',$user_id)->where('order_number',null)->orderBy('brand_id')->get();
            $brandBlocks = [];
            foreach ($cartItems as $cartItem) {
                $brandId = $cartItem->brand_id;

                // Kiểm tra nếu block sản phẩm của brand chưa tồn tại, thì khởi tạo nó
                if (!isset($brandBlocks[$brandId])) {
                    $brandBlocks[$brandId] = [
                        'brand' => $cartItem->brand,
                        'products' => []
                    ];
                }
                // Thêm sản phẩm vào block của brand
                $brandBlocks[$brandId]['products'][] = $cartItem->product;
            }
            return $brandBlocks;
        }
        else{
            return collect();
        }
    }
    // Total amount cart of a shop
    public static function totalShopCartPrice($brand_id){
        if(Auth::check()){
            $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)
                ->where('order_number',null)
                ->where('brand_id', $brand_id)
                ->sum('amount');
        }
        else{
            return 0;
        }
    }
    // Total amount cart
    public static function totalCartPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_number',null)->sum('amount');
        }
        else{
            return 0;
        }
    }
    // Wishlist Count
    public static function wishlistCount($user_id=''){

        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    public static function getAllProductFromWishlist($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::with('product')->where('user_id',$user_id)->where('cart_id',null)->get();
        }
        else{
            return collect();
        }
    }
    public static function totalWishlistPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('amount');
        }
        else{
            return 0;
        }
    }

    // Total price with shipping and coupon
    public static function grandPrice($id,$user_id){
        $order=Order::find($id);
        dd($id);
        if($order){
            $shipping_price=(float)$order->shipping->price;
            $order_price=self::orderPrice($id,$user_id);
            return number_format((float)($order_price+$shipping_price),2,'.','');
        }else{
            return 0;
        }
    }


    // Admin home
    public static function earningPerMonth(){
        $month_data=Order::where('status','delivered')->get();
        // return $month_data;
        $price=0;
        foreach($month_data as $data){
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price),2,'.','');
    }

    public static function shipping(){
        return Shipping::orderBy('id','DESC')->get();
    }

    public static function base64_url_encode( $data ) {
        return strtr( base64_encode($data), '+/=', '-_,' );
    }

    public static function base64_url_decode( $data ) {
        return base64_decode( strtr($data, '-_,', '+/=') );
    }

    public static function setReferrer($user_id) {
        $prefix = 100000;
        return $prefix + $user_id;
    }

    public static function getReferrer($refferrer) {
        $prefix = 100000;
        return $refferrer - $prefix;
    }

    public static function QrCodeReferrer($user_id, $size = 100) {
        $link = route('register.form', ['r' => self::setReferrer($user_id)]);
        return QrCode::eyeColor(0, 12, 144, 140, 230, 223, 68)->color(12, 144, 140)->size($size)->generate($link);
    }

    public static function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}

?>
