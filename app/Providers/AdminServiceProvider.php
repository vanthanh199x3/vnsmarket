<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\Shop;
use App\Models\Message;

class AdminServiceProvider extends ServiceProvider
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
                $countWithdraᴡ = Transaction::where(['transaction_type' => 4, 'status' => 0])->count();
                $countOrder = Order::where(['is_delete' => 0, 'status' => 'new'])->count();
                $countShop = Shop::where(['status' => 0])->count();
                $countContactMessage = Message::where(['read_at' => null])->count();
                
                $view->with('countWithdraᴡ', $countWithdraᴡ);
                $view->with('countOrder', $countOrder);
                $view->with('countShop', $countShop);
                $view->with('countContactMessage', $countContactMessage);
            }  
        });  
    }
}
