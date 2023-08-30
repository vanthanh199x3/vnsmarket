<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Product;

class updateShopProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto update shop product info';

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
        $ids = Product::where('is_import', 1)->pluck('id')->toArray();
        
        if (!empty($ids)) {
            $query = Product::on('dbcenter')->whereIn('id', $ids);
            $query->chunk(500, function ($products) {
                foreach ($products as $product) {
                    $data = $product->toArray();
                    $data['is_import'] = 1;
                    Product::updateOrCreate(['id' => $data['id']], $data);
                }
            });
        }
        
        return 0;
    }
}
