<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();
        $shop = \App\Models\Shop::selectRaw("id")->whereRaw('CONCAT(`shop_domain`,".",`base_domain`) = "' . config('app.domain') . '"')->first();
        $data=array(
            'shop_id' => $shop->id,
            'description'=>"DSV là hệ sinh thái kinh doanh số trực thuộc Công ty Cổ Phần Nền Tảng Số Việt nam, cung cấp đa dạng tiện ích và giải pháp kinh doanh số như: Sàn Thương Mại Điện Tử, Website bán hàng cá nhân, Cộng đồng kinh doanh số, Công cụ hỗ trợ Marketing, Sản phẩm dịch vụ công nghệ. Ra đời với mục đích mang đến giải pháp tiếp thị và bán hàng thông minh cho các cá nhân và doanh nghiệp trong thời đại công nghệ số.",
            'short_des'=>"DSV là hệ sinh thái kinh doanh số trực thuộc Công ty Cổ Phần Nền Tảng Số Việt nam, cung cấp đa dạng tiện ích và giải pháp kinh doanh số như: Sàn Thương Mại Điện Tử, Website bán hàng cá nhân, Cộng đồng kinh doanh số, Công cụ hỗ trợ Marketing, Sản phẩm dịch vụ công nghệ. Ra đời với mục đích mang đến giải pháp tiếp thị và bán hàng thông minh cho các cá nhân và doanh nghiệp trong thời đại công nghệ số.",
            'photo'=> 'https://metadsv.vn/frontend/img/logo.jpg',
            'logo'=> 'https://metadsv.vn/frontend/img/logo.jpg',
            'address'=>"109/6/7 QL 1A , Phường An phú đông, Quận 12, TP Hồ Chí Minh - Việt Nam",
            'email'=>"cskh@metadsv.vn",
            'phone'=>"0961.967.543",
        );
        DB::table('settings')->insert($data);
    }
}
