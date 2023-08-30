<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Shop;
use App\Models\Order;

class ShopServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            if (auth()->user()) {

                $shop = Shop::on('dbcenter')->where(['user_id' => auth()->user()->id])->first();
                
                if (!empty($shop)) {
                    
                    $shop->shop_admin = 0;
                    if($shop->status == 1 && $shop->url() == request()->getSchemeAndHttpHost()) {
                        $shop->shop_admin = 1;
                    }
                    $view->with('shop', $shop);
                }

                $countOrder = Order::where(['is_delete' => 0, 'status' => 'new'])->count();
                $view->with('countOrder', $countOrder);
            }  
        });  
    }
}
