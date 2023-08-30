<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class updateShopOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto update shop order status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $order_numbers = Order::where('status', '<>', 'delivered')
        ->orWhere('status', '<>', 'cancel')
        ->orWhere('bonus_status', '<>', 1)
        ->pluck('order_number')->toArray();

        if (!empty($order_numbers)) {
            $query = Order::on('dbcenter')->whereIn('order_number', $order_numbers);
            $query->chunk(500, function ($orders) {
                foreach ($orders as $order) {
                    $data = $order->toArray();
                    Order::updateOrCreate(['order_number' => $data['order_number']], [
                        'status' => $data['status'],
                        // 'payment_status' => $data['payment_status'],
                        'bonus_status' => $data['bonus_status'],
                    ]);
                }
            });
        }
        
        return 0;
    }
}
